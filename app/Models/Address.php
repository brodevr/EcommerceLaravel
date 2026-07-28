<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'label', 'recipient', 'street',
        'city', 'state', 'postal_code', 'phone', 'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function missingFields(): array
    {
        $required = [
            'recipient'   => 'destinatario',
            'street'      => 'calle',
            'city'        => 'ciudad',
            'state'       => 'provincia',
            'postal_code' => 'código postal',
        ];

        return collect($required)
            ->reject(fn ($label, $field) => filled($this->{$field}))
            ->values()
            ->all();
    }

    public function isComplete(): bool
    {
        return empty($this->missingFields());
    }
}
