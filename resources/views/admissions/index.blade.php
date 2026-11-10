@extends('layouts.school')

@section('title', 'Admissions review | Amiru International School')

@section('content')
<main class="portal-page">
    <div class="portal-heading">
        <div><p class="eyebrow">SCHOOL OFFICE</p><h1>Admissions <em>applications.</em></h1><p>Review applications and update their status.</p></div>
        <a class="button button-dark" href="{{ route('portal') }}">Back to portal</a>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>Application</th><th>Learner</th><th>Applying for</th><th>Guardian contact</th><th>Status &amp; review</th></tr></thead>
            <tbody>
            @forelse ($admissions as $admission)
                <tr>
                    <td><strong>{{ $admission->application_number }}</strong><small>{{ $admission->submitted_at->format('M j, Y') }}</small></td>
                    <td>{{ $admission->first_name }} {{ $admission->last_name }}</td>
                    <td>{{ $admission->applying_for }}</td>
                    <td>{{ $admission->guardian_name }}<small>{{ $admission->guardian_email }} · {{ $admission->guardian_phone }}</small></td>
                    <td><form method="POST" action="{{ route('admissions.update', $admission) }}" class="review-form">@csrf @method('PATCH')<select name="status" aria-label="Application status"><option value="submitted" @selected($admission->status === 'submitted')>Submitted</option><option value="under_review" @selected($admission->status === 'under_review')>Under review</option><option value="accepted" @selected($admission->status === 'accepted')>Accepted</option><option value="waitlisted" @selected($admission->status === 'waitlisted')>Waitlisted</option><option value="rejected" @selected($admission->status === 'rejected')>Rejected</option></select><input name="review_notes" value="{{ $admission->review_notes }}" placeholder="Review notes" aria-label="Review notes"><button class="button button-green" type="submit">Save</button></form></td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty-state">No admission applications have been received yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $admissions->links() }}</div>
</main>
@endsection
