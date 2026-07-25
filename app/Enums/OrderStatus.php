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

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pendiente  => 'bg-yellow-100 text-yellow-800',
            self::Procesando => 'bg-blue-100 text-blue-800',
            self::Enviado    => 'bg-purple-100 text-purple-800',
            self::Entregado  => 'bg-green-100 text-green-800',
            self::Cancelado  => 'bg-red-100 text-red-800',
        };
    }
}
