<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'amount',
        'note'
    ];

    public function scopeInvoiceData(Builder $query): void
    {
        $query->select('id', 'user_id', 'invoice_number', 'amount', 'note', 'created_at')
        ->with('userInvoice', fn($query) => $query->select('id', 'name', 'email'));
    }

    public function userInvoice(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
