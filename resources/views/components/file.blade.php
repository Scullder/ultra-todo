@props([
    'value' => '',
    'slot' => null,
    'label' => false,
    'name' => '',
    'id' => '',
    'preview' => false,
])

<div {{ $attributes->merge(['class' => 'mb-2']) }}>
    @if ($label)
        <label for="{{ $id }}" class="form-label mb-1 mt-0">{{ $label }}</label>
    @endif

    <div class="d-flex">
        <input class="form-control @error(dot_name($name)) is-invalid @enderror" 
            type="file"
            value="{{ $value }}" 
            name="{{ $name }}" 
            id="{{ $id }}"
            accept=".png,.jpg,.jpeg" 
        >
        <button class="btn btn-danger ms-2" type="button" id="clear-preview-{{ $id }}">очистить</button>
    </div>

    <div class="w-100 border rounded p-2 mt-2 @if (!$preview) visually-hidden @endif" id="preview-{{ $id }}">
        @if ($preview)
            <img src="{{ $preview }}" style="width: 150px; height: 150px;"/>
        @endif
    </div>
   
    @error(dot_name($name))
        <label class="invalid-feedback">{{ $message }}</label>
    @enderror
</div>

<script type="module">
    const id = '{{ $id }}'

    $(`#${id}`).on('change', (e) => {
        renderPreview(e, `${id}`)
    })

    $(`#clear-preview-${id}`).on('click', () => {
        $(`#${id}`).val('').trigger('change')
    })

    $(`#preview-${id} img`).on('click', (e) => {
        openImage(e)
    })

    const openImage = (e) => {
        window.open($(e.target).attr("src"));   
    }

    const renderPreview = (e, id) => {
        const [file] = e.target.files
        const preview = $(`#preview-${id}`)
        
        preview.find('img').remove()

        if (file) {
            const src = URL.createObjectURL(file)
            const img = $(`<img src="${src}" id="preview-${id}" class="" style="width: 150px; height: 150px;" />`)
            img.on('click', e => openImage(e))

            preview.append(img)
            preview.removeClass('visually-hidden')

            return
        }

        preview.addClass('visually-hidden').find('img').remove()
    }
</script>
