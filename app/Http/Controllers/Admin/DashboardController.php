<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::where('is_active', true)->count();
        $totalCategories = ProductCategory::where('is_active', true)->count();
        $today = Carbon::today();
        $totalCompletedOrdersToday = Order::where('status', 'selesai')
            ->whereDate('updated_at', $today)
            ->count();
        $totalRevenueToday = (float) Order::where('status', 'selesai')
            ->whereDate('updated_at', $today)
            ->sum('total');

        $categories = ProductCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function (ProductCategory $category) {
                return [
                    'name' => $category->name,
                    'count' => $category->products()->where('is_active', true)->count(),
                    'color' => $category->color ?: '#6B7280',
                ];
            });

        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $completedOrdersInRange = Order::query()
            ->where('status', 'selesai')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->get(['total', 'updated_at']);

        $revenueByWeekday = [];
        foreach ($completedOrdersInRange as $order) {
            $weekdayIso = (int) Carbon::parse($order->updated_at)->dayOfWeekIso; // 1=Mon ... 7=Sun
            $revenueByWeekday[$weekdayIso] = ($revenueByWeekday[$weekdayIso] ?? 0) + (float) $order->total;
        }

        $weekdayLabels = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        $dateLabels = [];
        $dateValues = [];

        foreach ($weekdayLabels as $weekdayIso => $weekdayName) {
            $dateLabels[] = $weekdayName;
            $dateValues[] = (float) ($revenueByWeekday[$weekdayIso] ?? 0);
        }

        $latestProducts = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalCompletedOrdersToday' => $totalCompletedOrdersToday,
            'totalRevenueToday' => $totalRevenueToday,
            'latestProducts' => $latestProducts,
            'categoryLabels' => $categories->pluck('name')->values()->all(),
            'categoryValues' => $categories->pluck('count')->values()->all(),
            'categoryColors' => $categories->pluck('color')->values()->all(),
            'dateLabels' => $dateLabels,
            'dateValues' => $dateValues,
            'systemInfo' => [
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'server_time' => Carbon::now()->format('d.m.Y H:i:s'),
                'timezone' => config('app.timezone'),
                'environment' => config('app.env'),
                'debug_mode' => config('app.debug') ? 'Aktif' : 'Nonaktif',
            ],
        ]);
    }
}
