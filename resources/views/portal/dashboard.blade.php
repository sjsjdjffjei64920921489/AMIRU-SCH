@extends('layouts.school')

@section('title', 'My portal | Amiru International School')

@section('content')
<main class="portal-page">
    <div class="portal-heading">
        <div><p class="eyebrow">AMIRU SCHOOL PORTAL</p><h1>Good day, <em>{{ $user->name }}.</em></h1><p class="role-label">{{ str($user->role)->replace('_', ' ')->title() }} portal</p></div>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="button button-outline" type="submit">Sign out</button></form>
    </div>
    @if ($user->role === 'administrator')
        <section class="stats-grid">
            <article class="stat-card"><span class="stat-symbol">✳</span><p>Enrolled learners</p><strong>{{ number_format($studentCount) }}</strong><small>Amiru student records</small></article>
            <article class="stat-card"><span class="stat-symbol">↗</span><p>Applications to review</p><strong>{{ number_format($pendingAdmissions) }}</strong><small>Submitted or under review</small></article>
            <article class="stat-card"><span class="stat-symbol">◌</span><p>School classes</p><strong>{{ number_format($classCount) }}</strong><small>Classes in the school database</small></article>
        </section>
        <section class="portal-section-heading">
            <div><p class="eyebrow">LATEST ACTIVITY</p><h2>Recent <em>applications.</em></h2></div>
        </section>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Application</th><th>Applicant</th><th>Applying for</th><th>Status</th><th>Submitted</th></tr></thead>
                <tbody>
                    @forelse ($recentAdmissions as $admission)
                        <tr>
                            <td>{{ $admission->application_number }}</td>
                            <td>{{ $admission->first_name }} {{ $admission->last_name }}</td>
                            <td>{{ $admission->applying_for }}</td>
                            <td>{{ str($admission->status)->replace('_', ' ')->title() }}</td>
                            <td>{{ $admission->submitted_at->format('M j, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td class="empty-state" colspan="5">No admission applications have been submitted yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <a class="tool-link" href="{{ route('admissions.index') }}">View all applications <b>↗</b></a>
    @elseif ($student)
        <section class="student-summary"><p class="eyebrow">STUDENT PROFILE</p><h2>{{ $student->first_name }} {{ $student->last_name }}</h2><p>Admission number <strong>{{ $student->admission_number }}</strong> · Class <strong>{{ $student->schoolClass?->name ?? 'Not assigned' }}</strong></p></section>
    @else
        <section class="student-summary"><p class="eyebrow">YOUR SCHOOL PORTAL</p><h2>Everything for your day at Amiru.</h2><p>Your account is set up. Your school administrator can link your staff or student profile to unlock personalised information.</p></section>
    @endif
    <div class="portal-section-heading"><div><p class="eyebrow">SCHOOL TOOLS</p><h2>Explore your <em>workspace.</em></h2></div></div>
    <section class="portal-tools">
        @if (in_array($user->role, ['administrator', 'admissions_officer'], true))
            <a class="portal-tool" href="{{ route('admissions.index') }}"><span class="tool-number">01</span><h3>Admissions</h3><p>Review submitted applications and record decisions.</p><span class="tool-link">Open admissions <b>↗</b></span></a>
        @endif
        <a class="portal-tool" href="{{ route('portal.timetable') }}"><span class="tool-number">02</span><h3>Academics</h3><p>Academic years, terms, classes, and subject assignments.</p><span class="tool-link">Open timetable <b>↗</b></span></a>
        <a class="portal-tool" href="{{ route('portal.attendance') }}"><span class="tool-number">03</span><h3>Attendance</h3><p>Attendance records by learner, class, and school day.</p><span class="tool-link">Open register <b>↗</b></span></a>
        <a class="portal-tool" href="{{ route('portal.timetable') }}"><span class="tool-number">04</span><h3>Timetable</h3><p>Class schedules, teachers, subjects, and rooms.</p><span class="tool-link">Open timetable <b>↗</b></span></a>
        <a class="portal-tool" href="{{ route('portal.report-cards') }}"><span class="tool-number">05</span><h3>Examinations</h3><p>Assessments, marks, and student results.</p><span class="tool-link">Open report cards <b>↗</b></span></a>
        <a class="portal-tool" href="{{ route('portal.report-cards') }}"><span class="tool-number">06</span><h3>Report cards</h3><p>Term summaries with teacher and principal comments.</p><span class="tool-link">Open report cards <b>↗</b></span></a>
    </section>
</main>
@endsection
