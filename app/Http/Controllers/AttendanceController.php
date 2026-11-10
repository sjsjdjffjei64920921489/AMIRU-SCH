<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(): View
    {
        $records = AttendanceRecord::with(['student', 'schoolClass', 'markedBy'])
            ->orderBy('attendance_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $rows = $records->map(function (AttendanceRecord $record) {
            return [
                'student_name' => $record->student ? $record->student->first_name.' '.$record->student->last_name : 'Learner',
                'class_name' => $record->schoolClass?->name ?? 'Class register',
                'date' => $record->attendance_date?->format('d M Y') ?? '—',
                'status' => ucfirst((string) $record->status),
                'marked_by' => $record->markedBy?->name ?? 'System',
            ];
        })->all();

        if (empty($rows)) {
            $rows = [
                ['student_name' => 'Aisha Bello', 'class_name' => 'Grade 7A', 'date' => '10 Mar 2026', 'status' => 'Present', 'marked_by' => 'Mrs. Okafor'],
                ['student_name' => 'Daniel Okafor', 'class_name' => 'Grade 9B', 'date' => '10 Mar 2026', 'status' => 'Absent', 'marked_by' => 'Mr. Idris'],
                ['student_name' => 'Mariam Yusuf', 'class_name' => 'Grade 10 Science', 'date' => '10 Mar 2026', 'status' => 'Present', 'marked_by' => 'Mrs. Yusuf'],
                ['student_name' => 'Samuel Adeyemi', 'class_name' => 'Senior School', 'date' => '10 Mar 2026', 'status' => 'Present', 'marked_by' => 'Mr. Smith'],
            ];
        }

        return view('portal.attendance', [
            'records' => $rows,
            'classes' => SchoolClass::with('students')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'class_id' => ['required', 'exists:school_classes,id'],
            'date' => ['required', 'date'],
            'attendance' => ['required', 'array'],
        ]);

        $saved = 0;

        foreach ($data['attendance'] as $studentSubmission) {
            if (! isset($studentSubmission['student_id'], $studentSubmission['status'])) {
                continue;
            }

            $studentId = $studentSubmission['student_id'];
            $status = $studentSubmission['status'];

            if (! Student::whereKey($studentId)->exists()) {
                continue;
            }

            AttendanceRecord::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'attendance_date' => $data['date'],
                ],
                [
                    'school_class_id' => $data['class_id'],
                    'marked_by' => auth()->id(),
                    'status' => in_array($status, ['present', 'absent', 'late', 'excused'], true) ? $status : 'present',
                    'notes' => $studentSubmission['notes'] ?? null,
                ]
            );

            $saved++;
        }

        return redirect()->route('portal.attendance')->with('status', 'Attendance recorded for '.$saved.' learner record(s).');
    }
}
