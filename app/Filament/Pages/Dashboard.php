<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\RevenueChart;
use App\Filament\Widgets\OrdersChart;
use App\Filament\Widgets\RecentOrders;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'bxs-dashboard';

    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): ?string
    {
        return static::$navigationIcon;
    }

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            RevenueChart::class,
            OrdersChart::class,
            RecentOrders::class,
        ];
    }

    public function getTitle(): string
    {
        return __('Beranda');
    }
}
