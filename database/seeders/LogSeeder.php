<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LogEntry;
use Carbon\Carbon;

class LogSeeder extends Seeder
{
    public function run(): void
    {
        LogEntry::create([
            'user_id' => 1,
            'date' => Carbon::now()->subDays(2),
            'hours_worked' => 8,
            'tasks' => 'Developed and tested the internship log entry form.',
            'skills' => 'Laravel, Blade, Bootstrap',
            'challenges' => 'Adjusting layout for mobile view.',
            'learnings' => 'Improved understanding of responsive design in Laravel.'
        ]);

        LogEntry::create([
            'user_id' => 1,
            'date' => Carbon::now()->subDay(),
            'hours_worked' => 6,
            'tasks' => 'Added Recent Log Entries table with dynamic data.',
            'skills' => 'Eloquent, Blade Templating, Bootstrap Tables',
            'challenges' => 'Formatting data with Carbon and table styling.',
            'learnings' => 'Learned Carbon date formatting and data binding.'
        ]);

        LogEntry::create([
            'user_id' => 1,
            'date' => Carbon::now(),
            'hours_worked' => 7,
            'tasks' => 'Integrated database seeding and factory generation.',
            'skills' => 'Laravel Seeder, Database Management',
            'challenges' => 'Ensuring relationships between tables were correct.',
            'learnings' => 'Gained deeper knowledge of Laravel seeding and migrations.'
        ]);
    }
}
