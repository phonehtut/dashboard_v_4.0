<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StartOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $chartData = $this->getStudentRegistrationData();

        return [
            Stat::make('Total Student', Student::count())
                ->description('This is Student Count')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success')
                ->chart($chartData),
            Stat::make('Total Review', Review::count())
                ->color('primary')
                ->description('This is Review Count')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->chart([7,3,4,5,6,3,4])
        ];
    }

    private function getStudentRegistrationData()
    {
        // Example: Getting the count of students registered each day for the last 8 days
        $data = Student::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count', 'date')
            ->toArray();

        // Fill missing dates with 0 counts
        $chartData = [];
        for ($i = 7; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartData[] = $data[$date] ?? 0;
        }

        return $chartData;
    }
}
