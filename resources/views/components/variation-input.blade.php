@php
    $initialIndex = $variations->isEmpty() ? 1 : $variations->count();
@endphp

<div id="variations-wrapper" class="space-y-6">
    @if ($variations->isEmpty())
        {{-- Variação inicial se estiver criando um novo produto --}}
        <div class="variation-item bg-white/5 p-4 rounded flex items-center gap-4" data-index="0">
            <x-input
                name="variations[0][name]"
                placeholder="Nome da variação"
                required
            />

            <x-input
                name="variations[0][quantity]"
                placeholder="Quantidade em estoque"
                type="number"
                min="0"
                required
            />
            <x-button onclick="removeVariation(this)" class="btn-danger">
                🗑️
            </x-button>
        </div>
    @else
        @foreach ($variations as $index => $variation)
            <div class="bg-white/5 p-4 rounded flex items-center gap-4 variation-item" data-index="{{ $index }}">
                <x-input
                    name="variations[{{ $index }}][id]"
                    :value="$variation->id"
                    hidden
                    required
                />
                <x-input
                    name="variations[{{ $index }}][name]"
                    :value="$variation->name"
                    placeholder="Nome da variação"
                    required
                />

                <x-input
                    name="variations[{{ $index }}][quantity]"
                    :value="optional($variation->stock)->quantity"
                    placeholder="Quantidade em estoque"
                    type="number"
                    min="0"
                    required
                />

                <x-button onclick="removeVariation(this)" class="btn-danger">
                    🗑️
                </x-button>
            </div>
        @endforeach
    @endif
</div>

<div class="mt-4 flex justify-between gap-4">
    <x-button onclick="addVariation()" class="btn-positive">Adicionar Variação</x-button>
</div>

@once
    @push('scripts')
        <script>
            let variationIndex = {{ $initialIndex }};

            function addVariation() {
                const wrapper = document.getElementById('variations-wrapper');

                const item = document.createElement('div');
                item.className = 'bg-white/5 p-4 rounded flex items-center gap-4 variation-item';
                item.dataset.index = variationIndex;

                item.innerHTML = `
                     <x-input
                name="variations[${variationIndex}][name]"
                placeholder="Nome da variação"
                required
            />

            <x-input
                name="variations[${variationIndex}][quantity]"
                placeholder="Quantidade em estoque"
                type="number"
                min="0"
                required
            />

            <x-button onclick="removeVariation(this)" class="btn-danger">
                🗑️
            </x-button>
                `;

                wrapper.appendChild(item);
                variationIndex++;
            }

            function removeVariation(button) {
                const wrapper = document.getElementById('variations-wrapper');
                const items = wrapper.querySelectorAll('.variation-item');

                if (items.length <= 1) {
                    // Só permite remover se tiver mais de 1 variação
                    alert('É necessário ter pelo menos uma variação.');
                    return;
                }

                const item = button.closest('.variation-item');
                item.remove();
            }

            function removeLastVariation() {
                const wrapper = document.getElementById('variations-wrapper');
                const items = wrapper.querySelectorAll('.variation-item');
                if (items.length > 0) {
                    wrapper.removeChild(items[items.length - 1]);
                    variationIndex--;
                }
            }
        </script>
    @endpush
@endonce
