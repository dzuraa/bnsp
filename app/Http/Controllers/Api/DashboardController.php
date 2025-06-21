<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'Active')->count();
        $lowStock = Product::where('stock', '<', 10)->count();

        return response()->json([
            'total_products' => $totalProducts,
            'active_products' => $activeProducts,
            'low_stock' => $lowStock,
        ]);
    }
}
