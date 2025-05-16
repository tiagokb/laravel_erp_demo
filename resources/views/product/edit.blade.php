<x-layout>
    <div class="card">
        <div class="card-header">
            <h1>
                Editar Produto
            </h1>
        </div>
        <div class="card-body">
            <form class="form-layer" method="post" action="{{route('products.update', $product->id)}}">
                @method('PATCH')
                @csrf
                <x-input
                    name="name"
                    label="Nome do Produto"
                    :value="$product->name ?? ''"
                    required
                />

                <x-money-input
                    name="price"
                    label="Quanto seu produto vai custar?"
                    :value="$product->price ?? ''"
                    required
                />

                <div class="form-actions">
                    <x-button class="btn-primary" type="submit">
                        Editar
                    </x-button>

                    <x-button href="{{route('products.index')}}" class="btn-danger">
                        Cancelar
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
