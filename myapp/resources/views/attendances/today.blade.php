@extends('layouts.app')

@section('title', 'Отметка посещаемости')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Отметка посещаемости на {{ $date->format('d.m.Y') }}</h1>
    <div>
        <input type="date" id="datePicker" class="form-control d-inline-block w-auto" value="{{ $date->format('Y-m-d') }}">
        <button id="changeDate" class="btn btn-outline-primary">Изменить дату</button>
    </div>
</div>

@if($students->count() > 0)
    <div class="card">
        <div class="card-body">
            <form action="{{ route('attendances.store') }}" method="POST" id="attendanceForm">
                @csrf
                <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}" id="selectedDate">

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Студент</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="attendances[{{ $student->id }}]"
                                                   id="present_{{ $student->id }}" value="present"
                                                   {{ ($attendances[$student->id] ?? 'present') === 'present' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="present_{{ $student->id }}">Присутствует</label>

                                            <input type="radio" class="btn-check" name="attendances[{{ $student->id }}]"
                                                   id="absent_{{ $student->id }}" value="absent"
                                                   {{ ($attendances[$student->id] ?? '') === 'absent' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger" for="absent_{{ $student->id }}">Отсутствует</label>

                                            <input type="radio" class="btn-check" name="attendances[{{ $student->id }}]"
                                                   id="late_{{ $student->id }}" value="late"
                                                   {{ ($attendances[$student->id] ?? '') === 'late' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="late_{{ $student->id }}">Опоздал</label>

                                            <input type="radio" class="btn-check" name="attendances[{{ $student->id }}]"
                                                   id="excused_{{ $student->id }}" value="excused"
                                                   {{ ($attendances[$student->id] ?? '') === 'excused' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-secondary" for="excused_{{ $student->id }}">Освобожден</label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-info">Карточка</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-lg">Сохранить посещаемость</button>
                    <a href="{{ route('attendances.report') }}" class="btn btn-outline-secondary">Посмотреть отчеты</a>
                </div>
            </form>
        </div>
    </div>
@else
    <div class="alert alert-info">
        <h4>Нет активных студентов</h4>
        <p>Сначала <a href="{{ route('students.create') }}">добавьте студентов</a> в систему.</p>
    </div>
@endif

<script>
document.getElementById('changeDate').addEventListener('click', function() {
    const newDate = document.getElementById('datePicker').value;
    if (newDate) {
        window.location.href = '/attendances/today?date=' + newDate;
    }
});

document.getElementById('datePicker').addEventListener('change', function() {
    document.getElementById('selectedDate').value = this.value;
});
</script>
@endsection
