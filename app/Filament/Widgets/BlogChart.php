<?php

// namespace App\Filament\Widgets;

// use App\Models\Blog;
// use Filament\Widgets\ChartWidget;

// class BlogChart extends ChartWidget
// {
//     protected static ?string $heading = 'Chart';

//     protected function getData(): array
//     {
//         // Fetch student data from your database or any other source
//         $blogs = Blog::all();

//         // Initialize an array to store the blog count for each month
//         $blogchart = array_fill(0, 12, 0);

//         // Loop through the students and count them based on their creation month
//         foreach ($blogs as $blog) {
//             $monthIndex = $blog->created_at->format('n') - 1; // Month index starts from 0
//             $blogchart[$monthIndex]++;
//         }

//         // Prepare the data array for the chart
//         $data = [
//             'datasets' => [
//                 [
//                     'label' => 'batch created',
//                     'data' => $blogchart,
//                 ],
//             ],
//             'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
//         ];

//         return $data;
//     }

//     protected function getType(): string
//     {
//         return 'line';
//     }
// }
