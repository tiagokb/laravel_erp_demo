<x-layout>

    <div class="card">
        <div class="card-header">
            <h1>
                Criar Novo Produto
            </h1>
        </div>
        <div class="card-body">
            <form class="form-layer" action="{{ route('products.store') }}" method="post">
                @csrf
                <x-input
                    name="name"
                    label="Como vamos chamar seu produto?"
                    maxlength="35"
                    required
                />

                <x-money-input
                    name="price"
                    label="Quanto seu produto vai custar?"
                    :value="'0.00'"
                    required
                />

                <h2>
                    Variações
                </h2>

                <x-variation-input />

                <div class="form-actions">

                    <x-button type="submit" class="btn-primary">
                        Criar
                    </x-button>

                    <x-button href="{{route('products.index')}}" class="btn-danger">
                        Cancelar
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
