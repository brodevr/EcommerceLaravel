<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pendiente  = 'pendiente';
    case Procesando = 'procesando';
    case Enviado    = 'enviado';
    case Entregado  = 'entregado';
    case Cancelado  = 'cancelado';

    public function label(): string
    {
        return match ($this) {
            self::Pendiente  => 'Pendiente',
            self::Procesando => 'Procesando',
            self::Enviado    => 'Enviado',
            self::Entregado  => 'Entregado',
            self::Cancelado  => 'Cancelado',
        };
    }

    public function transitions(): array
    {
        return match ($this) {
            self::Pendiente  => [self::Procesando, self::Cancelado],
            self::Procesando => [self::Enviado, self::Cancelado],
            self::Enviado    => [self::Entregado],
            self::Entregado  => [],
            self::Cancelado  => [],
        };
    }

    public function canTransitionTo(self $next): bool
    {
        return in_array($next, $this->transitions());
    }
}
