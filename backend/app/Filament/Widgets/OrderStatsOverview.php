<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $todayRevenue = Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->sum('total');

        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');

        return [
            Stat::make('আজকের অর্ডার', Order::whereDate('created_at', today())->count()),
            Stat::make('পেন্ডিং অর্ডার', Order::where('status', 'pending')->count()),
            Stat::make('আজকের বিক্রয়', '৳' . number_format($todayRevenue, 2)),
            Stat::make('সর্বমোট বিক্রয়', '৳' . number_format($totalRevenue, 2)),
        ];
    }
}
