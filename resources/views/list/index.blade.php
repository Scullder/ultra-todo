@extends('layouts.app-auth')

@section('content')
    <div class="p-5">
        @if ($lists->count())
            <div class="row row-cols-4 g-2">
                @foreach ($lists as $item)
                    <div class="col" style="height: 200px;">
                        <div class="bg-light border p-3 h-100 rounded">
                            <div class="d-flex mb-2 justify-content-between align-items-center">
                                <div class="">{{ $item->created_at }}</div>
                                <form action="{{ route('lists.destroy', ['list' => $item->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger btn-sm">x</button>
                                </form>
                            </div>
                            <a href="{{ route('lists.show', ['list' => $item->id]) }}">
                                <h3>{{ $item->title }}</h3>
                            </a>
                            @if ($item->description)
                                <p class="overflow-auto" style="max-height: 80%;">
                                    {{ $item->description }}
                                </p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('lists.edit', ['list' => $item->id]) }}"
                                    class="btn btn-success">Редактировать</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="fs-3 mt-5 text-center">Нет добавленных списков!</div>
        @endif
    </div>
@endsection
