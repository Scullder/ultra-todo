@extends('layouts.app-auth')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-black text-decoration-none fs-1">{{ $list->title }}</h1>
        <a href="{{ route('tasks.create', ['list' => $list->id]) }}" class="btn btn-primary">Добавить задачу</a>
    </div>
    <hr>

    <div class="mb-4">
        <form action="{{ route('lists.show', ['list' => $list->id]) }}" method="get">
            <div class="d-flex">
                <input type="text" value="{{ request()->query('search') }}" name="search" class="form-control bg-white" placeholder="Поиск по тегам">
                <button class="btn btn-secondary ms-2" style="min-width: 160px;"> поиск </button>
            </div>
        </form>
    </div>

    @if ($list->tasks->count())
        <div class="d-flex flex-column">
            @foreach ($list->tasks as $task)
                <div class="border rounded bg-light p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            @if ($task->image)
                                <img src="{{ asset('storage/' . $task->image) }}" class="rounded me-3" style="width:80px; height: 80px;"/>
                            @endif 
                            <h3><a href={{ route('tasks.edit', ['list' => $list->id, 'task' => $task->id]) }}>{{ $task->title }}</a></h3>
                        </div>
                        <form action="{{ route('tasks.destroy', ['list' => $list->id, 'task' => $task->id]) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger">удалить</button>
                        </form>
                    </div>
                    @if ($task->tags->count())
                        <div class="mt-2">
                            {{ implode(', ', array_column($task->tags->toArray(), 'tag')) }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else 
        <div class="fs-3 mt-5 text-center">В списке ещё нет добавленных задач!</div>
    @endif
@endsection

