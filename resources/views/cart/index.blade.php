@inject('cart', 'App\Services\CartService')
<x-layout>
    <div class="card">
        <div class="card-header">
            <h1>Seu Carrinho</h1>
        </div>

        <div class="card-body">
            <form class="form-layer" method="post"
                  action="{{route('cart.buyer')}}">
                @csrf
                <x-input
                    name="email"
                    type="email"
                    label="Email"
                    placeholder="comprador@montink.com.br"
                    :value="$cart->email()"
                    required
                />
                <x-input
                    id="cep"
                    name="cep"
                    type="text"
                    maxlength="8"
                    label="CEP"
                    placeholder="12345678"
                    :value="$cart->cep()"
                    required
                />
                <x-input
                    name="house_number"
                    label="Número da residência"
                    placeholder="300"
                    class="w-fit"
                    value="{{ $cart->houseNumber() }}"
                    required
                />
                <x-input
                    name="code"
                    label="Código"
                    placeholder="Cupom 10"
                    :value="$cart->couponCode()"
                />
                <div class="form-actions">
                    <x-button type="submit" class="btn-positive mt-5">
                        Cadastrar comprador
                    </x-button>
                </div>
            </form>

            @if($cartItems->isEmpty())
                <p class="text-white/50 px-8 py-16">Seu carrinho está vazio.</p>
                <x-button :href="route('products.index')" class="btn-primary">
                    Voltar a lista de produtos
                </x-button>
            @else
                <table class="table-default">
                    <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Variação</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cartItems as $index => $item)
                        <tr>
                            <td>{{ $item['product']->name }}</td>
                            <td>{{ $item['variation']->name ?? 'N/A' }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>R$ {{ number_format($item['unit_price'] / 100, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($item['total'] / 100, 2, ',', '.') }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove') }}">
                                    @csrf
                                    <input type="hidden" name="index" value="{{ $index }}">
                                    <button type="submit" class="text-red-600 hover:underline">Remover</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="card-footer flex flex-col gap-4 justify-end items-end">
            <p>Frete: <span id="shipping" class="text-green-300">Preencha o CEP e calcule o frete!</span></p>
            <p>Subtotal: <span
                    class="text-green-300">R$ {{ number_format($cart->subTotal() / 100, 2, ',', '.') }}</span></p>
            <p>Desconto: <span
                    class="text-green-300">R$ {{ number_format($cart->discount() / 100, 2, ',', '.') }}</span></p>
            <p>Total: <span id="total" class="text-green-300">Preencha o CEP e calcule o frete!</span></p>
            <form method="post" action="{{ route('cart.buy') }}">
                @csrf
                <x-button id="checkout-button-id" type="submit" disabled
                          class="btn-primary text-nowrap disabled:opacity-50 disabled:cursor-not-allowed">
                    Finalizar Compra
                </x-button>
            </form>
        </div>
    </div>
</x-layout>
<script>

    const cartData = {
        shipping: {{ $cart->shippingValue() }},
        total: {{ $cart->total() }}
    };

    const selectors = {
        cepInput: () => document.getElementsByName('cep'),
        shippingDisplay: () => document.getElementById('shipping'),
        totalDisplay: () => document.getElementById('total'),
    };

    function isCepValid(cep) {
        return /^\d{8}$/.test(cep.trim());
    }

    function disableCheckoutButton(state) {
        const cartButton = document.getElementById('checkout-button-id');

        if (!cartButton) return;

        const shippingDisplay = selectors.shippingDisplay();
        const totalDisplay = selectors.totalDisplay();

        if (state) {
            cartButton.disabled = true;
            shippingDisplay.textContent = "Preencha o CEP e calcule o frete!";
            totalDisplay.textContent = "Preencha o CEP e calcule o frete!";
        } else {
            cartButton.disabled = false;
            shippingDisplay.textContent = "R$ " + formatCurrency(cartData.shipping);
            totalDisplay.textContent = "R$ " + formatCurrency(cartData.total);
        }
    }

    function formatCurrency(valueInCents) {
        return (valueInCents / 100).toFixed(2).replace('.', ',');
    }

    function initCepField() {
        const cepInputs = document.getElementsByName('cep');

        if (!cepInputs.length) return;

        cepInputs.forEach(cepInput => {
            // Permitir apenas números
            cepInput.addEventListener('keypress', e => {
                if (!/\d/.test(e.key)) e.preventDefault();
            });

            // Validação ao mudar o valor do campo
            cepInput.addEventListener('keyup', () => {
                console.log('blur')
                const isValid = isCepValid(cepInput.value);
                disableCheckoutButton(!isValid);
            });

            const isValid = isCepValid(cepInput.value);
            disableCheckoutButton(!isValid);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initCepField();
    });
</script>
