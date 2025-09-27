<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceItem;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Daily / weekly / monthly sales report
    public function salesByPeriod(Request $request)
    {
        $validated = $request->validate([
            'period' => 'required|in:daily,weekly,monthly',
            'date' => 'nullable|date', // reference date (default today)
        ]);

        $date = $request->date ? Carbon::parse($request->date) : Carbon::now();

        switch ($validated['period']) {
            case 'daily':
                $start = $date->copy()->startOfDay();
                $end = $date->copy()->endOfDay();
                break;

            case 'weekly':
                $start = $date->copy()->startOfWeek();
                $end = $date->copy()->endOfWeek();
                break;

            case 'monthly':
                $start = $date->copy()->startOfMonth();
                $end = $date->copy()->endOfMonth();
                break;
        }

        $totalSales = SalesInvoice::whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->sum('total_amount');

        $invoiceCount = SalesInvoice::whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->count();

        return response()->json([
            'period' => $validated['period'],
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'total_sales' => $totalSales,
            'invoices_count' => $invoiceCount,
        ]);
    }

    // Sales by employee (user)
    public function salesByEmployee(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $query = SalesInvoice::select('user_id', DB::raw('SUM(total_amount) as total_sales'), DB::raw('COUNT(*) as invoices_count'))
            ->where('status', 'completed')
            ->groupBy('user_id')
            ->with('user:id,name,email');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $validated['start_date']);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $validated['end_date']);
        }

        $reports = $query->get();

        return response()->json($reports);
    }

    // Sales by category
    public function salesByCategory(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Join sales_invoice_items -> items -> categories with sales_invoices filter
        $query = DB::table('sales_invoice_items')
            ->join('sales_invoices', 'sales_invoice_items.sales_invoice_id', '=', 'sales_invoices.id')
            ->join('items', 'sales_invoice_items.item_id', '=', 'items.id')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->select('categories.id', 'categories.name', DB::raw('SUM(sales_invoice_items.total) as total_sales'))
            ->where('sales_invoices.status', 'completed')
            ->groupBy('categories.id', 'categories.name');

        if ($request->filled('start_date')) {
            $query->whereDate('sales_invoices.created_at', '>=', $validated['start_date']);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('sales_invoices.created_at', '<=', $validated['end_date']);
        }

        $results = $query->get();

        return response()->json($results);
    }

    // Top-selling items report
    public function topSellingItems(Request $request)
    {
        $validated = $request->validate([
            'limit' => 'nullable|integer|min:1|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $limit = $validated['limit'] ?? 10;

        $query = DB::table('sales_invoice_items')
            ->join('sales_invoices', 'sales_invoice_items.sales_invoice_id', '=', 'sales_invoices.id')
            ->join('items', 'sales_invoice_items.item_id', '=', 'items.id')
            ->select('items.id', 'items.name', DB::raw('SUM(sales_invoice_items.quantity) as total_quantity_sold'))
            ->where('sales_invoices.status', 'completed')
            ->groupBy('items.id', 'items.name')
            ->orderByDesc('total_quantity_sold');

        if ($request->filled('start_date')) {
            $query->whereDate('sales_invoices.created_at', '>=', $validated['start_date']);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('sales_invoices.created_at', '<=', $validated['end_date']);
        }

        $results = $query->limit($limit)->get();

        return response()->json($results);
    }
}
