<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeliModel extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pembelian';
    protected $fillable = [
        'inventory_id',
        'jumlah'
    ];
}
