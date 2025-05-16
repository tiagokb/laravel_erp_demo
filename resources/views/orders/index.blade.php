<x-layout>
    <div class="card">
        <div class="card-header">
            <h1>Pedidos</h1>
        </div>
        <div class="card-body">
            <table class="table-default">
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Valor Líquido
                    </th>
                    <th>
                        Cupom
                    </th>
                    <th>
                        CEP
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Status
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <th>
                            {{ $order->id }}
                        </th>
                        <th>
                            R$ {{ $order->net_value }}
                        </th>
                        <th>
                            {{ $order->coupon->code ?? '-' }}
                        </th>
                        <th>
                            {{ $order->cep }}
                        </th>
                        <th>
                            {{ $order->email }}
                        </th>
                        <th>
                            {{ $order->status }}
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
