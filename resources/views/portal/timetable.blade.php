@extends('layouts.school')

@section('title', 'Timetable | Amiru International School')

@section('content')
<main class="portal-page">
    <div class="portal-heading">
        <div>
            <p class="eyebrow">AMIRU SCHOOL PORTAL</p>
            <h1>Academic <em>timetable.</em></h1>
            <p>Current term: <strong>{{ $currentTerm }}</strong></p>
        </div>
        <a class="button button-outline" href="{{ route('portal') }}">Back to dashboard</a>
    </div>

    <div class="portal-toolbar">
        <div class="portal-toolbar-group">
            <span>Term view</span>
            <strong>{{ $currentTerm }}</strong>
        </div>
        <div class="portal-toolbar-group">
            <span>Records</span>
            <strong>{{ count($entries) }}</strong>
        </div>
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Room</th>
                    <th>Term</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($entries as $entry)
                    <tr>
                        <td>{{ $entry['class_name'] }}</td>
                        <td>{{ $entry['subject'] }}</td>
                        <td>{{ $entry['teacher'] }}</td>
                        <td>{{ $entry['day'] }}</td>
                        <td>{{ $entry['time'] }}</td>
                        <td>{{ $entry['room'] }}</td>
                        <td>{{ $entry['term'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="empty-state" colspan="7">No timetable entries are available for this academic term.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
