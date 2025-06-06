<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = 'id';
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'description',
        'image',
    ];

    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class);
    }
}
