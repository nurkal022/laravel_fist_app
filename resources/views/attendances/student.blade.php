@extends('layouts.app')

@section('title', 'Посещаемость студента')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Посещаемость: {{ $student->name }}</h1>
    <div>
        <a href="{{ route('students.show', $student) }}" class="btn btn-outline-secondary">Карточка студента</a>
        <a href="{{ route('attendances.today') }}" class="btn btn-primary">Отметить посещаемость</a>
    </div>
</div>

@if($attendances->count() > 0)
    @php
        $totalDays = $attendances->total();
        $presentDays = $attendances->where('status', 'present')->count();
        $absentDays = $attendances->where('status', 'absent')->count();
        $lateDays = $attendances->where('status', 'late')->count();
        $excusedDays = $attendances->where('status', 'excused')->count();
        $attendancePercent = $totalDays > 0 ? round(($presentDays + $lateDays) / $totalDays * 100, 1) : 0;
    @endphp

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-success">{{ $presentDays }}</h5>
                    <p class="card-text">Присутствовал</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-danger">{{ $absentDays }}</h5>
                    <p class="card-text">Отсутствовал</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-warning">{{ $lateDays }}</h5>
                    <p class="card-text">Опоздал</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title {{ $attendancePercent >= 80 ? 'text-success' : ($attendancePercent >= 60 ? 'text-warning' : 'text-danger') }}">
                        {{ $attendancePercent }}%
                    </h5>
                    <p class="card-text">Посещаемость</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Статус</th>
                            <th>Заметки</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->date->format('d.m.Y') }}</td>
                                <td>
                                    <span class="badge
                                        @if($attendance->status === 'present') bg-success
                                        @elseif($attendance->status === 'absent') bg-danger
                                        @elseif($attendance->status === 'late') bg-warning
                                        @else bg-secondary
                                        @endif">
                                        @if($attendance->status === 'present') Присутствовал
                                        @elseif($attendance->status === 'absent') Отсутствовал
                                        @elseif($attendance->status === 'late') Опоздал
                                        @else Освобожден
                                        @endif
                                    </span>
                                </td>
                                <td>{{ $attendance->notes ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $attendances->links() }}
        </div>
    </div>
@else
    <div class="alert alert-info">
        <h4>Нет данных о посещаемости</h4>
        <p>У этого студента пока нет записей о посещаемости.</p>
    </div>
@endif
@endsection
