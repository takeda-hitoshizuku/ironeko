<?php

namespace App\Filament\Widgets;

use App\Models\Cat;
use App\Models\AdoptionEvent;
use App\Models\ActivityPost;
use App\Models\Inquiry;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('募集中の猫', Cat::where('status', 'available')->count())
                ->description('譲渡可能な猫の数')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('預かり前の猫', Cat::where('status', 'fostering')->count())
                ->description('保護中の猫')
                ->descriptionIcon('heroicon-m-heart')
                ->color('warning'),

            Stat::make('今月の譲渡会', AdoptionEvent::whereMonth('event_date', now()->month)
                ->whereYear('event_date', now()->year)
                ->where('status', 'scheduled')
                ->count())
                ->description('今月開催予定')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),

            Stat::make('未対応のお問い合わせ', Inquiry::where('status', 'new')->count())
                ->description('要対応')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('danger'),
        ];
    }
}
