<?php

namespace App\Enums;

enum Role: string
{
    case Cliente = 'cliente';
    case Admin   = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Cliente => 'Cliente',
            self::Admin   => 'Administrador',
        };
    }
}
