@php
    $inputId = str_replace(['.', '[]', '[', ']'], '_', $name); // Garante um ID válido pro HTML
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);     // Converte "product[name]" para "product.name"
@endphp

<div class="form-group">
    <label class="form-label" for="{{ $inputId }}">{{ $label }}</label>
    <input
        id="{{ $inputId }}"
        name="{{ $name }}"
        type="{{ $type }}"
        class="form-input @error($errorKey) border-red-500 @enderror"
        value="{{ old($name, $value) }}"
        {{ $attributes }}
    />

    @error($errorKey)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
