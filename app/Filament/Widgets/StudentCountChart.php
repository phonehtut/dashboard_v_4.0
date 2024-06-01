<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Student; // Assuming you have a Student model

class StudentCountChart extends ChartWidget
{
    protected static ?string $heading = 'Student';

    protected function getData(): array
    {
        // Fetch student data from your database or any other source
        $students = Student::all();

        // Initialize an array to store the student count for each month
        $studentCount = array_fill(0, 12, 0);

        // Loop through the students and count them based on their creation month
        foreach ($students as $student) {
            $monthIndex = $student->created_at->format('n') - 1; // Month index starts from 0
            $studentCount[$monthIndex]++;
        }

        // Prepare the data array for the chart
        $data = [
            'datasets' => [
                [
                    'label' => 'Student created',
                    'data' => $studentCount,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];

        return $data;
    }

    protected function getType(): string
    {
        return 'line';
    }
}
