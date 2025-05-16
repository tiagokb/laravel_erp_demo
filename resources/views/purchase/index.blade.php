@inject('viaCepValidator', 'App\Services\ViaCepService')
<x-layout>
    <div class="max-w-5xl mx-auto mt-10 text-white">
        <h1>Comprar: {{ $product->name }}</h1>

        <div class="flex flex-col md:flex-row bg-white/5 rounded overflow-hidden shadow-lg">
            <div class="md:w-1/2 w-full bg-white/10 p-6 flex items-center justify-center">
                <div class="w-full h-64 md:h-80 bg-white/20 animate-pulse rounded-lg"></div>
            </div>

            <div class="md:w-1/2 w-full p-6 space-y-6">
                <div>
                    <p class="text-white/70">Preço</p>
                    <p class="text-xl font-semibold">R$ {{$product->price}}</p>
                </div>

                <form action="{{ route('purchase.cart', $product->id) }}" method="POST" class="form-layer">
                    @csrf

                    <x-input
                        id="quantity"
                        name="quantity"
                        label="Quantidade"
                        value="1"
                        min="1"
                        max="1000"
                        type="number"
                        data-price="{{ preg_replace('/\D/', '', $product->price) }}"
                        required
                    />

                    @if ($product->variations->isNotEmpty())
                        <x-select id="variation-select" name="variation-select" label="Variação">
                            @forelse ($product->variations as $variation)
                                <option value="{{ $variation->id }}" class="bg-black/80 text-white">
                                    {{ $variation->name }} ({{ $variation->stock->quantity ?? 0 }} disponíveis)
                                </option>
                            @empty
                                <option disabled>
                                    Nenhuma variação disponível
                                </option>
                            @endforelse
                        </x-select>
                    @endif

                    <x-button id="add-to-cart-button" type="submit"
                              class="btn-positive">
                        Adicionar ao Carrinho
                    </x-button>
                </form>

                <div class="flex flex-row justify-end items-center">
                    <p>Subtotal: <span class="text-green-300">R$</span> <span id="subtotal"
                                                                              class="text-green-300">{{$product->price}}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>
    const selectors = {
        quantityInput: () => document.getElementById('quantity'),
        subtotalDisplay: () => document.getElementById('subtotal'),
    };

    function calculateSubtotal(price, quantity) {
        return price * quantity;
    }

    function updateSubtotalDisplay() {
        const price = getProductPrice();
        const quantity = getQuantity();
        const subtotal = calculateSubtotal(price, quantity);
        selectors.subtotalDisplay().textContent = (subtotal / 100)
            .toFixed(2)
            .replace('.', ',');
    }

    function getProductPrice() {
        // Usa data attribute no input
        return parseInt(selectors.quantityInput().dataset.price);
    }

    function getQuantity() {
        return parseInt(selectors.quantityInput().value) || 1;
    }

    function initQuantityField() {
        const quantityInput = selectors.quantityInput();
        if (!quantityInput) return;

        quantityInput.addEventListener('input', () => {
            updateSubtotalDisplay();
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initQuantityField();
        updateSubtotalDisplay();
    });
</script>
