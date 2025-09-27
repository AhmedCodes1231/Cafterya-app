<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesInvoice;
use App\Models\Item;
use App\Models\SalesInvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;


class SalesInvoiceController extends Controller
{
    // Create invoice with auto-generated number & validation
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0', // price per unit at sale time
        ]);

        DB::beginTransaction();
        try {
            // Generate invoice number - YYYYMMDD + 4 digit incremental
            $date = Carbon::now()->format('Ymd');
            $lastInvoiceToday = SalesInvoice::whereDate('created_at', Carbon::today())
                ->orderBy('invoice_number', 'desc')
                ->first();

            $lastNumber = $lastInvoiceToday ? intval(substr($lastInvoiceToday->invoice_number, 8)) : 0;
            $newNumber = $lastNumber + 1;
            $invoiceNumber = $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            // Create sales invoice
            /*$invoice = SalesInvoice::create([
                'invoice_number' => $invoiceNumber,
                'customer_name' => $data['customer_name'] ?? null,
                'user_id' => $request->user()->id,
                'total_amount' => 0, // Will update later
                'status' => 'completed',
            ]);*/
            $invoice = SalesInvoice::create([
    'invoice_number' => $invoiceNumber,
    'customer_name' => $data['customer_name'] ?? null,
    'user_id' => $request->user()->id,
    'invoice_type_id' => 1, // أو أي رقم نوع فاتورة مناسب
    'total_amount' => 0,
    'status' => 'completed',
]);

            $totalAmount = 0;

            foreach ($data['items'] as $itemData) {
                $item = Item::lockForUpdate()->find($itemData['item_id']);
                if (!$item) {
                    throw ValidationException::withMessages(['items' => 'Item not found: ID ' . $itemData['item_id']]);
                }

                if ($item->stock !== null && $item->stock < $itemData['quantity']) {
                    throw ValidationException::withMessages(['items' => "Insufficient stock for item: {$item->name}"]);
                }

                // Deduct stock
                if ($item->stock !== null) {
                    $item->stock -= $itemData['quantity'];
                    $item->save();
                }

                $lineTotal = $itemData['price'] * $itemData['quantity'];
                $totalAmount += $lineTotal;

                // Create invoice item details
                /*SalesInvoice::create([
                    'sales_invoice_id' => $invoice->id,
                    'item_id' => $item->id,
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'total' => $lineTotal,
                ]);*/
                SalesInvoiceDetail::create([
    'sales_invoice_id' => $invoice->id,
    'item_id' => $item->id,
    'quantity' => $itemData['quantity'],
    'price' => $itemData['price'],
    'total' => $lineTotal,
]);
            }

            $invoice->total_amount = $totalAmount;
            $invoice->save();

            DB::commit();

            return response()->json([
                'message' => 'Invoice created successfully',
                'invoice' => $invoice->load('items.item')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create invoice',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    // Show invoice details by ID
    public function show(SalesInvoice $salesInvoice)
    {
        $salesInvoice->load('items.item', 'user');

        return response()->json($salesInvoice);
    }

    // Process return for an invoice item
    public function processReturn(Request $request, SalesInvoice $salesInvoice)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $totalRefund = 0;

            foreach ($data['items'] as $returnItem) {
                $invoiceItem = $salesInvoice->items()->where('item_id', $returnItem['item_id'])->first();

                if (!$invoiceItem) {
                    throw ValidationException::withMessages(['items' => 'Item not found in invoice: ID ' . $returnItem['item_id']]);
                }

                if ($returnItem['quantity'] > $invoiceItem->quantity) {
                    throw ValidationException::withMessages(['items' => 'Return quantity exceeds sold quantity for item ID ' . $returnItem['item_id']]);
                }

                // Update invoice item quantity and total
                $invoiceItem->quantity -= $returnItem['quantity'];
                $lineRefund = $returnItem['quantity'] * $invoiceItem->price;
                $invoiceItem->total -= $lineRefund;

                if ($invoiceItem->quantity == 0) {
                    $invoiceItem->delete();
                } else {
                    $invoiceItem->save();
                }

                // Refund total amount on invoice
                $totalRefund += $lineRefund;

                // Restock the item
                $item = Item::lockForUpdate()->find($returnItem['item_id']);
                if ($item->stock !== null) {
                    $item->stock += $returnItem['quantity'];
                    $item->save();
                }

                // Optionally log the return in a separate returns table (not shown)

            }

            // Update invoice total_amount
            $salesInvoice->total_amount -= $totalRefund;

            // Adjust status if fully returned
            if ($salesInvoice->items()->count() === 0) {
                $salesInvoice->status = 'returned';
            }

            $salesInvoice->save();

            DB::commit();

            return response()->json([
                'message' => 'Return processed successfully',
                'invoice' => $salesInvoice->load('items.item')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to process return',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
