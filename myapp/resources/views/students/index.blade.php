@extends('layouts.app')

@section('title', 'Студенты')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Студенты</h1>
    <a href="{{ route('students.create') }}" class="btn btn-primary">Добавить студента</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Телефон</th>
                        <th>Email</th>
                        <th>Дата рождения</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->phone ?: '-' }}</td>
                            <td>{{ $student->email ?: '-' }}</td>
                            <td>{{ $student->birth_date ? $student->birth_date->format('d.m.Y') : '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-primary">Просмотр</a>
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-secondary">Редактировать</a>
                                    <a href="{{ route('attendances.student', $student) }}" class="btn btn-sm btn-outline-info">Посещаемость</a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Вы уверены, что хотите деактивировать этого студента?')">
                                            Деактивировать
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Студентов пока нет</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $students->links() }}
    </div>
</div>
@endsection
