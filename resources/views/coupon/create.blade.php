<x-layout>
    <div class="card">
        <div class="card-header">
            <h1>Criar Cupom</h1>
        </div>

        <div class="card-body">
            <form class="form-layer" method="post" action="{{route('coupons.store')}}">
                @csrf
                <x-input
                    name="code"
                    label="Código do cupom"
                    placeholder="O nome deve ser único"
                    type="text"
                    maxlength="14"
                    required
                />

                <x-money-input
                    name="discount"
                    label="Valor do Desconto"
                    :value="'0.00'"
                    required
                />

                <x-money-input
                    name="min_value"
                    label="Valor mínimo para uso do cupom"
                    :value="'0.00'"
                    required
                />

                <x-input
                    name="expires_at"
                    label="Data de expiração do cupom"
                    placeholder="dd/mm/aaaa"
                    type="date"
                    required
                />

                <div class="form-actions">
                    <x-button type="submit" class="btn-primary">
                        Criar
                    </x-button>
                    <x-button :href="route('coupons.index')" class="btn-danger">
                        Cancelar
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
