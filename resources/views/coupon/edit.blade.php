<x-layout>
    <div class="card">
        <div class="card-header">
            <h1>Editar Cupom: <span class="text-green-300">{{$coupon->code}}</span></h1>
        </div>

        <div class="card-body">
            <form class="form-layer" method="post" action="{{route('coupons.update', $coupon->id)}}">
                @method('PATCH')
                @csrf

                <x-money-input
                    name="discount"
                    label="Valor do Desconto"
                    :value="$coupon->discount"
                    required
                />

                <x-money-input
                    name="min_value"
                    label="Valor mínimo para uso do cupom"
                    :value="$coupon->min_value"
                    required
                />

                <x-input
                    name="expires_at"
                    label="Data de expiração do cupom"
                    placeholder="dd/mm/aaaa"
                    :value="$coupon->unformattedExpiresAt()"
                    type="date"
                    required
                />

                <div class="form-actions">
                    <x-button type="submit" class="btn-primary">
                        Editar
                    </x-button>
                    <x-button :href="route('coupons.index')" class="btn-danger">
                        Cancelar
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
