<x-layout>
    <div class="card">
        <div class="card-header">
            <h1>
                <strong>Produtos</strong>
            </h1>
            <x-button href="{{route('products.create')}}" class="btn-primary">
                Novo
            </x-button>
        </div>

        <div class="card-body">
            <table class="table-default">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque Total</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->name}}</td>
                        <td>R$ {{$product->price}}</td>
                        <td>
                            <a href="{{route('stock.show', $product->id)}}"
                               class="inline-flex items-center gap-1">
                                {{$product->totalStock()}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M14 3h7v7m0 0L10 21l-7-7 11-11z"/>
                                </svg>
                            </a>
                        </td>
                        <td>
                            <div class="action-buttons">

                                <x-button class="btn-primary" :href="route('products.edit', $product->id)">
                                    Editar
                                </x-button>

                                <x-button class="btn-positive" :href="route('purchase.index', $product->id)">
                                    Comprar
                                </x-button>

                                <form method="POST" action="{{route('products.destroy', $product->id)}}">
                                    @csrf
                                    @method('DELETE')

                                    <x-button type="submit" class="btn-danger">
                                        Excluir
                                    </x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
