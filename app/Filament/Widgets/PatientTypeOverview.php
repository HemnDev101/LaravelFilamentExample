<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatientTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
           Stat::make('Cats' , Patient::query()->where('type' , 'cat')-> count())  ->description('32k increase')
               ->descriptionIcon('heroicon-m-arrow-trending-up')->color('primary'),
            Stat::make('Dogs' , Patient::query()->where('type' , 'dog')-> count())  ->description('7% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-down')->color('info'),
            Stat::make('Rabbits' , Patient::query()->where('type' , 'rabbit')-> count())  ->description('3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')->color('warning')   ->extraAttributes([
        'class' => 'cursor-pointer',
        'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
    ]),

            Stat::make('Unique views' , '123.1k')    ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

        ];
    }
}
