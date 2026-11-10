@extends('layouts.school')

@section('title', 'Attendance | Amiru International School')

@section('content')
<main class="portal-page">
    <div class="portal-heading">
        <div>
            <p class="eyebrow">AMIRU SCHOOL PORTAL</p>
            <h1>Attendance <em>register.</em></h1>
            <p>Track learners for the selected school day.</p>
        </div>
        <a class="button button-outline" href="{{ route('portal') }}">Back to dashboard</a>
    </div>

    <div class="portal-tabs" aria-label="Class register tabs">
        <span class="portal-tab active">Class overview</span>
        <span class="portal-tab">Daily follow-up</span>
    </div>

    <div class="portal-split">
        <form class="school-form attendance-form" method="POST" action="{{ route('portal.attendance.store') }}">
            @csrf
            <p class="eyebrow">CLASS REGISTER</p>
            <h2>Record attendance</h2>

            <label for="class_id">Class</label>
            <select id="class_id" name="class_id" required>
                <option value="">Select a class</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>

            <label for="date">Attendance date</label>
            <input id="date" name="date" type="date" value="{{ now()->toDateString() }}" required>

            <div class="attendance-stack">
                @forelse ($classes->first()?->students ?? collect() as $student)
                    <div class="attendance-row">
                        <div>
                            <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>
                            <small>{{ $student->admission_number }}</small>
                        </div>
                        <input type="hidden" name="attendance[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                        <select name="attendance[{{ $loop->index }}][status]">
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="late">Late</option>
                            <option value="excused">Excused</option>
                        </select>
                    </div>
                @empty
                    <p class="empty-inline">No students are assigned to a class yet. Add a class roster before recording attendance.</p>
                @endforelse
            </div>

            <button class="button button-green button-full" type="submit">Save attendance</button>
        </form>

        <div class="attendance-history">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Marked by</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr>
                                <td>{{ $record['student_name'] }}</td>
                                <td>{{ $record['class_name'] }}</td>
                                <td>{{ $record['date'] }}</td>
                                <td>{{ $record['status'] }}</td>
                                <td>{{ $record['marked_by'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="empty-state" colspan="5">No attendance has been recorded for this school day.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
