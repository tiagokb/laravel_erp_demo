@if ($href)
    <a href="{{ $href }}" {{ $attributes->class(['btn', 'btn-secondary']) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class(['btn', 'btn-secondary']) }}>
        {{ $slot }}
    </button>
@endif
