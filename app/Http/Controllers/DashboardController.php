<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $isAdministrator = $user->role === 'administrator';
        $isAdmissionsStaff = in_array($user->role, ['administrator', 'admissions_officer'], true);

        return view('portal.dashboard', [
            'user' => $user,
            'student' => $user->student,
            'pendingAdmissions' => $isAdmissionsStaff
                ? Admission::whereIn('status', ['submitted', 'under_review'])->count()
                : null,
            'studentCount' => $isAdministrator ? Student::count() : null,
            'classCount' => $isAdministrator ? SchoolClass::count() : null,
            'recentAdmissions' => $isAdministrator
                ? Admission::latest('submitted_at')->limit(5)->get()
                : collect(),
        ]);
    }
}
