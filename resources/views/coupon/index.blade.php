<x-layout>
    <div class="card">
        <div class="card-header">
            <h1>Cupoms</h1>
            <x-button :href="route('coupons.create')" class="btn-primary">
                Novo
            </x-button>
        </div>

        <div class="card-body">
            <table class="table-default">
                <thead>
                <tr>
                    <th>
                        Código
                    </th>
                    <th>
                        Desconto
                    </th>
                    <th>
                        Valor Mínimo
                    </th>
                    <th>
                        Data de expiração
                    </th>
                    <th>
                        Ações
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($coupons as $coupon)
                    <tr>
                        <th>
                            {{ $coupon->code }}
                        </th>
                        <th>
                            R$ {{ $coupon->discount }}
                        </th>
                        <th>
                            R$ {{ $coupon->min_value }}
                        </th>
                        <th>
                            {{ $coupon->expires_at }}
                        </th>
                        <th>
                            <x-button :href="route('coupons.edit', $coupon->id)" class="btn-primary">
                                Editar
                            </x-button>
                        </th>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</x-layout>
