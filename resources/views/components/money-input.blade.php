@php
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);
@endphp

<div class="form-group">
    <label class="form-label" for="{{ $id }}">{{ $label }}</label>

    <div class="relative w-full">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
            R$
        </span>

        <input
            id="{{ $id }}"
            name="{{ $name }}"
            class="form-input pl-10 money-input @error($errorKey) border-red-500 @enderror"
            value="{{ old($name, $value) }}"
            type="text"
            inputmode="decimal"
            {{ $attributes }}
        />
    </div>

    @error($errorKey)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

@once
    @push('scripts')
        <script>
            document.querySelectorAll('.money-input').forEach(input => {
                input.addEventListener('input', (e) => {
                    let value = e.target.value.replace(/\D/g, '');
                    value = (Number(value) / 100).toFixed(2);
                    e.target.value = value;
                });

                input.addEventListener('keypress', (e) => {
                    if (!/\d/.test(e.key)) {
                        e.preventDefault();
                    }
                });
            });
        </script>
    @endpush
@endonce
