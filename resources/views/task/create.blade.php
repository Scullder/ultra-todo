@extends('layouts.app-auth')

@section('content')
    <h1 class="text-black text-decoration-none fs-1">Создание задачи</h1>
    <hr>
    <form action="{{ route('tasks.store', ['list' => $list->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-input value="" name="title" label="Название"/>
        <x-file value="" name="image" label="Изображение" id="image"/>
        <x-input value="" name="tags" label="Теги (через запятую)" type="textarea" />

        <button class="btn btn-success mt-3">сохранить</button>
    </form>
@endsection
