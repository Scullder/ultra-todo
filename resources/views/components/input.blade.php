@props([
    'value' => '', 
    'slot' => null,
    'label' => false,
    'name' => '',
    'placeholder' => '',
    'id' => '',
    'type' => 'text',
])

@if ($attributes['hidden'])
    <input type="text" value="{{ $value }}" name="{{ $name }}" hidden />
@else
    <div {{ $attributes->merge(['class' => 'mb-2']) }}>
        @if ($label)
            <label for="{{ $id }}" class="form-label mb-1 mt-0">{{ $label }}</label>
        @endif

        @if ($type == 'textarea')
            <textarea class="form-control @error(dot_name($name)) is-invalid @enderror"
                type="{{ $type }}" 
                name="{{ $name }}" 
                id="{{ $id }}" 
                placeholder="{{ $placeholder }}" 
                style="height: 130px;"
            >{{ $value }}</textarea>
        @else
            <input class="form-control @error(dot_name($name)) is-invalid @enderror"
                type="{{ $type }}" 
                value="{{ $value }}" 
                name="{{ $name }}" 
                id="{{ $id }}" 
                placeholder="{{ $placeholder }}" 
            >
        @endif

        @error(dot_name($name))
            <label class="invalid-feedback">{{ $message }}</label>
        @enderror
    </div>
@endif

