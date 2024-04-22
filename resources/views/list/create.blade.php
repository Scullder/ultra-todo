@extends('layouts.app-auth')

@section('content')
    <h1 class="text-black text-decoration-none fs-1">Создание списка</h1>
    <hr>
    <form action="{{ route('lists.store') }}" method="POST">
        @csrf
        <x-input value="" name="title" label="Название"/>
        <x-input value="" name="description" label="Описание" type="textarea"/>

        <button class="btn btn-success mt-3">сохранить</button>
    </form>
@endsection
