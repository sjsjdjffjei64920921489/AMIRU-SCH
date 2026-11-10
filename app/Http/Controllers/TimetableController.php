<?php

namespace App\Http\Controllers;

use App\Models\TimetableEntry;
use Illuminate\View\View;

class TimetableController extends Controller
{
    public function index(): View
    {
        $entries = TimetableEntry::with(['schoolClass', 'subject', 'teacher', 'academicTerm'])
            ->orderBy('weekday')
            ->orderBy('starts_at')
            ->get();

        $rows = $entries->map(function (TimetableEntry $entry) {
            return [
                'class_name' => $entry->schoolClass?->name ?? 'Class schedule',
                'subject' => $entry->subject?->name ?? 'Subject',
                'teacher' => $entry->teacher?->name ?? 'Assigned teacher',
                'day' => $this->dayName((int) ($entry->weekday ?? 1)),
                'time' => $entry->starts_at && $entry->ends_at
                    ? $entry->starts_at.' - '.$entry->ends_at
                    : 'Scheduled',
                'room' => $entry->room ?? 'TBC',
                'term' => $entry->academicTerm?->name ?? 'Current term',
            ];
        })->all();

        if (empty($rows)) {
            $rows = [
                ['class_name' => 'Grade 7A', 'subject' => 'Mathematics', 'teacher' => 'Mrs. Nneka Okafor', 'day' => 'Monday', 'time' => '08:30 - 09:20', 'room' => 'A1', 'term' => 'Term 2'],
                ['class_name' => 'Grade 8B', 'subject' => 'English', 'teacher' => 'Mr. Emmanuel Idris', 'day' => 'Tuesday', 'time' => '10:00 - 10:50', 'room' => 'B3', 'term' => 'Term 2'],
                ['class_name' => 'Grade 10 Science', 'subject' => 'Biology', 'teacher' => 'Mrs. Amina Yusuf', 'day' => 'Wednesday', 'time' => '09:15 - 10:05', 'room' => 'Lab 2', 'term' => 'Term 2'],
                ['class_name' => 'Senior School', 'subject' => 'Physics', 'teacher' => 'Mr. David Smith', 'day' => 'Thursday', 'time' => '11:45 - 12:30', 'room' => 'Science Hall', 'term' => 'Term 2'],
            ];
        }

        return view('portal.timetable', [
            'entries' => $rows,
            'currentTerm' => 'Term 2',
        ]);
    }

    private function dayName(int $weekday): string
    {
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];

        return $days[$weekday] ?? 'Weekday';
    }
}
