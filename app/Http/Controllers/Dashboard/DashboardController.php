<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $filter = $request->query('filter', 'daily');

        $ordersData = $this->getOrdersData($filter);
        $bestSellingProducts = $this->getBestSellingProducts();

        return view('dashboard.admin.dashboard', [
            'PageTitle' => trans('dashboard/header.main_dashboard'),
            'ordersPerDay' => $ordersData,
            'currentFilter' => $filter,
            'bestSellingProducts' => $bestSellingProducts,
        ]);
    }

    private function getOrdersData(string $filter)
    {
        return match ($filter) {
            'weekly' => $this?->getWeeklyData(),
            'monthly' => $this?->getMonthlyData(),
            'yearly' => $this?->getYearlyData(),
            default => $this?->getDailyData(),
        };
    }

    private function getDailyData()
    {
        /*return Order::selectRaw('DATE(created_at) as period, COUNT(*) as total, SUM(total_price) as total_price')
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->map(fn($item) => [
                'date' => $item->period,
                'total' => $item->total,
                'total_price' => $item->total_price,
            ]);*/
        return Order::selectRaw('DATE(created_at) as period, COUNT(*) as total, SUM(total_price) as total_price')
            ->groupBy('created_at')
            ->orderBy('created_at')
            ->get()
            ->map(fn($item) => [
                'date' => $item->period,
                'total' => $item->total,
                'total_price' => $item->total_price,
            ]);
    }

    private function getWeeklyData()
    {
        /*return Order::selectRaw("YEARWEEK(created_at, 1) as period, COUNT(*) as total, SUM(total_price) as total_price")
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->map(function ($item) {
                $year = substr($item->period, 0, 4);
                $week = substr($item->period, 4);
                $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
                return [
                    'date' => 'الأسبوع ' . $week . ' - ' . $startOfWeek->format('Y-m-d'),
                    'total' => $item->total,
                    'total_price' => $item->total_price,
                ];
            });*/
        return Order::selectRaw("YEARWEEK(created_at, 1) as period, COUNT(*) as total, SUM(total_price) as total_price")
            ->groupByRaw("YEARWEEK(created_at, 1)")
            ->orderByRaw("YEARWEEK(created_at, 1)")
            ->get()
            ->map(function ($item) {
                $year = substr($item->period, 0, 4);
                $week = substr($item->period, 4);
                $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
                return [
                    'date' => 'الأسبوع ' . $week . ' - ' . $startOfWeek->format('Y-m-d'),
                    'total' => $item->total,
                    'total_price' => $item->total_price,
                ];
            });
    }

    private function getMonthlyData()
    {
        /*return Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as period, COUNT(*) as total, SUM(total_price) as total_price")
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->map(fn($item) => [
                'date' => $item->period,
                'total' => $item->total,
                'total_price' => $item->total_price,
            ]);*/
        return Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as period, COUNT(*) as total, SUM(total_price) as total_price")
            ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m')")
            ->orderByRaw("DATE_FORMAT(created_at, '%Y-%m')")
            ->get()
            ->map(fn($item) => [
                'date' => $item->period,
                'total' => $item->total,
                'total_price' => $item->total_price,
            ]);
    }

    private function getYearlyData()
    {
        /*return Order::selectRaw("YEAR(created_at) as period, COUNT(*) as total, SUM(total_price) as total_price")
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->map(fn($item) => [
                'date' => $item->period,
                'total' => $item->total,
                'total_price' => $item->total_price,
            ]);*/
        return Order::selectRaw("YEAR(created_at) as period, COUNT(*) as total, SUM(total_price) as total_price")
            ->groupByRaw("YEAR(created_at)")
            ->orderByRaw("YEAR(created_at)")
            ->get()
            ->map(fn($item) => [
                'date' => $item->period,
                'total' => $item->total,
                'total_price' => $item->total_price,
            ]);
    }

    private function getBestSellingProducts()
    {
        return \DB::table('order_product')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->select('products.name', \DB::raw('SUM(order_product.quantity) as total_sold'))
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(10) // Show top 10
            ->get()
            ->map(fn($item) => [
                'name' => $item->name,
                'total_sold' => $item->total_sold,
            ]);
    }
}
