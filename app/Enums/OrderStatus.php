<?php

namespace App\Enums;

enum OrderStatus: string
{
    case WAITING_PAYMENT = 'waiting_payment';
    case PAID = 'paid';
    case CANCELED = 'canceled';
    case SHIPPED = 'shipped';

    public function label()
    {
        return match ($this) {
            self::WAITING_PAYMENT => __('Aguardando Pagamento'),
            self::PAID => __('Pago'),
            self::CANCELED => __('Cancelado'),
            self::SHIPPED => __('Enviado'),
        };
    }
}
