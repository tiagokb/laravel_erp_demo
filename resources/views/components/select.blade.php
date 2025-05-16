<div>
    <label for="{{$name}}" class="block text-sm text-white/70 mb-1">{{ $label }}</label>
    <select name="{{$name}}" {{ $attributes }}
            class="w-full bg-white/10 text-white placeholder-white/70 px-3 py-2 rounded
           focus:outline-none focus:ring-2 focus:ring-blue-500
           appearance-none">
        {{$slot}}
    </select>
</div>
