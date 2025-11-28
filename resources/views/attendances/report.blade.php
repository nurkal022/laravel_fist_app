@extends('layouts.app')

@section('title', 'Отчет по посещаемости')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Отчет по посещаемости</h1>
    <a href="{{ route('attendances.today') }}" class="btn btn-primary">Отметить посещаемость</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Дата начала</label>
                <input type="date" class="form-control" id="start_date" name="start_date"
                       value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">Дата окончания</label>
                <input type="date" class="form-control" id="end_date" name="end_date"
                       value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">Показать</button>
                <a href="{{ route('attendances.report') }}" class="btn btn-outline-secondary">Сбросить</a>
            </div>
        </form>
    </div>
</div>

@if($students->count() > 0)
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Студент</th>
                            <th>Всего дней</th>
                            <th>Присутствовал</th>
                            <th>Отсутствовал</th>
                            <th>Опоздал</th>
                            <th>Освобожден</th>
                            <th>Процент посещаемости</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            @php
                                $totalDays = $student->attendances->count();
                                $presentDays = $student->attendances->where('status', 'present')->count();
                                $absentDays = $student->attendances->where('status', 'absent')->count();
                                $lateDays = $student->attendances->where('status', 'late')->count();
                                $excusedDays = $student->attendances->where('status', 'excused')->count();
                                $attendancePercent = $totalDays > 0 ? round(($presentDays + $lateDays) / $totalDays * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('attendances.student', $student) }}">{{ $student->name }}</a>
                                </td>
                                <td>{{ $totalDays }}</td>
                                <td><span class="badge bg-success">{{ $presentDays }}</span></td>
                                <td><span class="badge bg-danger">{{ $absentDays }}</span></td>
                                <td><span class="badge bg-warning">{{ $lateDays }}</span></td>
                                <td><span class="badge bg-secondary">{{ $excusedDays }}</span></td>
                                <td>
                                    <span class="badge {{ $attendancePercent >= 80 ? 'bg-success' : ($attendancePercent >= 60 ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $attendancePercent }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info">
        <h4>Нет данных для отображения</h4>
        <p>В выбранном периоде нет записей о посещаемости.</p>
    </div>
@endif
@endsection
