@extends('layouts.app-auth')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-black text-decoration-none fs-1">Редактирование задачи</h1>
        <a href="{{ route('lists.show', ['list' => $list->id]) }}" class="fs-4"><b>Назад</b></a>
    </div>
    <hr>

    <div class="alert alert-success visually-hidden" role="alert"></div>
    <form action="{{ route('tasks.update', ['list' => $list->id, 'task' => $task]) }}" id="form-update" class="ajax-form">
        @csrf
        @method('put')
        <x-input value="{{ $task->title }}" name="title" label="Название" />
        <x-file value="{{ $task->image }}" name="image" label="Изображение" id="image" preview="{{ $task->image ? asset('storage/' . $task->image) : false }}" />
        <x-input value="{{ $tags }}" name="tags" label="Теги (через запятую)" type="textarea" />

        <button class="btn btn-success mt-3">сохранить</button>
    </form>
@endsection
