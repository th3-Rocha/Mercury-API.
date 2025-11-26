<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'owner_id',
        'name',
        'status',
        'wallet_balance',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'wallet_balance' => 'decimal:2',
    ];

    /**
     * Relacionamento: Uma empresa pertence a um dono (User)
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Relacionamento: Uma empresa pode ter vários usuários (futuramente)
     */
    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }
}
