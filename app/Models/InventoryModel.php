<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryModel extends Model
{
    use HasFactory;

    protected $table = 'master_inventory';
    protected $fillable = [
        'inventory_id',
        'nama',
        'harga',
        'stok',
    ];
}
