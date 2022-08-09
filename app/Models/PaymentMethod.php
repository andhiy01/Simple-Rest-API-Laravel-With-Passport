<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'admin_fee',
    ];

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payment_method_id');
    }
}
