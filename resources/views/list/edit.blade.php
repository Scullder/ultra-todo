@extends('layouts.app-auth')

@section('content')
    <h1 class="text-black text-decoration-none fs-1">Редактирование списка</h1>
    <hr>
    <div class="alert alert-success visually-hidden" role="alert"></div>
    <form action="{{ route('lists.update', ['list' => $list]) }}" id="form-update" class="ajax-form">
        @csrf
        @method('put')
        <x-input value="{{ $list->title }}" name="title" label="Название" />
        <x-input value="{{ $list->description }}" name="description" label="Описание" type="textarea" />

        <button class="btn btn-success mt-3">сохранить</button>
    </form>
@endsection
