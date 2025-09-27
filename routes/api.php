<?php
/*
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\SalesInvoiceController;
use App\Http\Controllers\Api\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
/*
// ---------------- Authentication ----------------
Route::post('/login', [AuthenticationController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthenticationController::class, 'logout']);

// ---------------- Protected Routes ----------------
Route::middleware('auth:sanctum')->group(function () {

    // ---- Categories ----
    Route::get('/categories', [CategoryController::class, 'index']);        // List with optional search
    Route::get('/categories/{category}', [CategoryController::class, 'show']); // Single category
    Route::post('/categories', [CategoryController::class, 'store']);       // Create
    Route::put('/categories/{category}', [CategoryController::class, 'update']); // Update
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']); // Delete

    // ---- Items ----
    Route::get('/items', [ItemController::class, 'index']);                // List items (filter by category or search)
    Route::get('/items/{item}', [ItemController::class, 'show']);         // Single item
    Route::post('/items', [ItemController::class, 'store']);              // Create item
    Route::put('/items/{item}', [ItemController::class, 'update']);       // Update item
    Route::delete('/items/{item}', [ItemController::class, 'destroy']);   // Delete item

    // ---- Sales Invoices ----
    Route::post('/sales-invoices', [SalesInvoiceController::class, 'store']); // Create invoice
    Route::get('/sales-invoices/{salesInvoice}', [SalesInvoiceController::class, 'show']); // Invoice details
    Route::post('/sales-invoices/{salesInvoice}/return', [SalesInvoiceController::class, 'processReturn']); // Process return

    // ---- Reports ----
    Route::get('/reports/sales-by-period', [ReportController::class, 'salesByPeriod']);       // Daily / Weekly / Monthly
    Route::get('/reports/sales-by-employee', [ReportController::class, 'salesByEmployee']);   // By employee
    Route::get('/reports/sales-by-category', [ReportController::class, 'salesByCategory']);   // By category
    Route::get('/reports/top-selling-items', [ReportController::class, 'topSellingItems']);   // Top items
});*/


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\SalesInvoiceController;
use App\Http\Controllers\Api\ReportController;

/*
Route::post('/login', [AuthenticationController::class, 'login']);
Route::middleware(['auth:sanctum', 'role:manager,staff'])->group(function () {
    Route::apiResource('categories', CategoryController::class);
});

Route::middleware(['auth:sanctum', 'role:manager,staff'])->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('items', ItemController::class);
    Route::apiResource('sales-invoices', SalesInvoiceController::class)->only(['store', 'show']);

    Route::get('/reports/sales-by-period', [ReportController::class, 'salesByPeriod']);
    Route::get('/reports/sales-by-employee', [ReportController::class, 'salesByEmployee']);
    Route::get('/reports/sales-by-category', [ReportController::class, 'salesByCategory']);
    Route::get('/reports/top-selling-items', [ReportController::class, 'topSellingItems']);
});*/


Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:manager,staff'])->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('items', ItemController::class);
    Route::apiResource('sales-invoices', SalesInvoiceController::class)->only(['store', 'show']);

    Route::get('/reports/sales-by-period', [ReportController::class, 'salesByPeriod']);
    Route::get('/reports/sales-by-employee', [ReportController::class, 'salesByEmployee']);
    Route::get('/reports/sales-by-category', [ReportController::class, 'salesByCategory']);
    Route::get('/reports/top-selling-items', [ReportController::class, 'topSellingItems']);
});
