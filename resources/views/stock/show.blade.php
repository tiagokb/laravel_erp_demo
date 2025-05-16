<x-layout>

    <div class="card">
        <div class="card-header">

            <h1>
                Controle de Estoque: {{ $product->name }}
            </h1>
            <span class="text-xl text-green-400 font-semibold">
                R$ {{ $product->price }}
            </span>
        </div>
        <div class="card-body">
            <form class="form-layer" method="POST" action="{{ route('stock.update', $product->id) }}">
                @csrf
                @method('PUT')
                <x-variation-input :variations="$product->variations" />
                <!-- Salvar alterações -->
                <div class="form-actions">
                    <x-button type="submit" class="btn-primary">
                        Salvar Alterações
                    </x-button>
                    <x-button :href="route('products.index')" class="btn-danger">
                        Cancelar
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
