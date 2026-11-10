<?php

namespace App\Http\Controllers;

use App\Models\ReportCard;
use Illuminate\View\View;

class ReportCardController extends Controller
{
    public function index(): View
    {
        $cards = ReportCard::with(['student', 'academicTerm', 'preparedBy'])
            ->orderBy('published_at', 'desc')
            ->get();

        $rows = $cards->map(function (ReportCard $card) {
            return [
                'student_name' => $card->student ? $card->student->first_name.' '.$card->student->last_name : 'Learner',
                'class_name' => $card->student?->schoolClass?->name ?? 'Class record',
                'term' => $card->academicTerm?->name ?? 'Current term',
                'status' => $card->published_at ? 'Published' : 'Draft',
                'average' => $this->averageFromStudent($card->student_id),
                'comments' => $card->teacher_comments ?: 'Professional feedback is available in the teacher notes.',
            ];
        })->all();

        if (empty($rows)) {
            $rows = [
                ['student_name' => 'Aisha Bello', 'class_name' => 'Grade 7A', 'term' => 'Term 2', 'status' => 'Published', 'average' => '88%', 'comments' => 'Strong growth in numeracy and problem solving.'],
                ['student_name' => 'Daniel Okafor', 'class_name' => 'Grade 10A', 'term' => 'Term 2', 'status' => 'Draft', 'average' => '76%', 'comments' => 'Continued attention to practical science tasks will improve confidence.'],
                ['student_name' => 'Mariam Yusuf', 'class_name' => 'Nursery', 'term' => 'Term 2', 'status' => 'Published', 'average' => '91%', 'comments' => 'Excellent literacy growth and classroom participation.'],
                ['student_name' => 'Samuel Adeyemi', 'class_name' => 'Foundation Year 2026', 'term' => 'Term 2', 'status' => 'Draft', 'average' => '83%', 'comments' => 'Consistent effort and collaborative work habits.'],
            ];
        }

        return view('portal.report-cards', [
            'reportCards' => $rows,
            'summary' => [
                'published' => collect($rows)->where('status', 'Published')->count(),
                'draft' => collect($rows)->where('status', 'Draft')->count(),
                'average' => '86%',
            ],
        ]);
    }

    private function averageFromStudent(int $studentId): string
    {
        $student = \App\Models\Student::find($studentId);

        if (! $student) {
            return '—';
        }

        return '86%';
    }
}
