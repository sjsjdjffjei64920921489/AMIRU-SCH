<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    public function create(): View
    {
        return view('admissions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::in(['female', 'male', 'prefer_not_to_say'])],
            'applying_for' => ['required', 'string', 'max:100'],
            'guardian_name' => ['required', 'string', 'max:200'],
            'guardian_email' => ['required', 'email', 'max:255'],
            'guardian_phone' => ['required', 'string', 'max:30'],
            'previous_school' => ['nullable', 'string', 'max:200'],
        ]);

        $data['application_number'] = 'AMI-'.now()->format('Ymd').'-'.strtoupper(str()->random(6));
        $data['status'] = 'submitted';
        $data['submitted_at'] = now();

        Admission::create($data);

        return redirect()->route('admissions.create')
            ->with('application_number', $data['application_number']);
    }

    public function index(): View
    {
        return view('admissions.index', [
            'admissions' => Admission::latest('submitted_at')->paginate(15),
        ]);
    }

    public function update(Request $request, Admission $admission): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['under_review', 'accepted', 'waitlisted', 'rejected'])],
            'review_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $admission->update($data);

        return back()->with('status', 'Application updated.');
    }
}
