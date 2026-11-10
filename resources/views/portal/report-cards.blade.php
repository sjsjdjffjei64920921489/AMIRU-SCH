@extends('layouts.school')

@section('title', 'Report Cards | Amiru International School')

@section('content')
<main class="portal-page">
    <div class="portal-heading">
        <div>
            <p class="eyebrow">AMIRU SCHOOL PORTAL</p>
            <h1>Report <em>cards.</em></h1>
            <p>Structured learner performance and term summaries.</p>
        </div>
        <a class="button button-outline" href="{{ route('portal') }}">Back to dashboard</a>
    </div>

    <section class="stats-grid">
        <article class="stat-card">
            <span class="stat-symbol">✓</span>
            <p>Published</p>
            <strong>{{ $summary['published'] }}</strong>
            <small>Term-based summaries available</small>
        </article>
        <article class="stat-card">
            <span class="stat-symbol">◌</span>
            <p>Drafts</p>
            <strong>{{ $summary['draft'] }}</strong>
            <small>Awaiting final approval</small>
        </article>
        <article class="stat-card">
            <span class="stat-symbol">↗</span>
            <p>Average</p>
            <strong>{{ $summary['average'] }}</strong>
            <small>Across the active report cards</small>
        </article>
    </section>

    <div class="portal-split portal-split-wide">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Term</th>
                        <th>Status</th>
                        <th>Average</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reportCards as $card)
                        <tr>
                            <td>{{ $card['student_name'] }}</td>
                            <td>{{ $card['class_name'] }}</td>
                            <td>{{ $card['term'] }}</td>
                            <td>{{ $card['status'] }}</td>
                            <td>{{ $card['average'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="empty-state" colspan="5">No report cards have been published for this term.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="school-form report-summary-form">
            <p class="eyebrow">TERM FEEDBACK</p>
            <h2>Teacher notes</h2>
            @forelse ($reportCards as $card)
                <div class="comment-card">
                    <strong>{{ $card['student_name'] }}</strong>
                    <p>{{ $card['comments'] }}</p>
                </div>
                @break
            @empty
                <p class="empty-inline">No learner notes are available yet.</p>
            @endforelse
        </div>
    </div>
</main>
@endsection
