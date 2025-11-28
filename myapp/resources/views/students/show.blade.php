@extends('layouts.app')

@section('title', 'Информация о студенте')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3>{{ $student->name }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Телефон:</strong> {{ $student->phone ?: 'Не указан' }}</p>
                <p><strong>Email:</strong> {{ $student->email ?: 'Не указан' }}</p>
                <p><strong>Дата рождения:</strong> {{ $student->birth_date ? $student->birth_date->format('d.m.Y') : 'Не указана' }}</p>
                <p><strong>Статус:</strong>
                    <span class="badge {{ $student->active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $student->active ? 'Активный' : 'Неактивный' }}
                    </span>
                </p>
                @if($student->notes)
                    <p><strong>Заметки:</strong> {{ $student->notes }}</p>
                @endif
            </div>
            <div class="card-footer">
                <div class="btn-group w-100">
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-primary">Редактировать</a>
                    <a href="{{ route('attendances.student', $student) }}" class="btn btn-outline-info">Посещаемость</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>История посещаемости</h4>
            </div>
            <div class="card-body">
                @if($attendances->count() > 0)
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
                @else
                    <p class="text-muted">История посещаемости пуста</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('students.index') }}" class="btn btn-secondary">← Назад к списку студентов</a>
</div>
@endsection
