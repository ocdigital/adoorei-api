<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model
{
    use HasFactory;
    use HasUuids; //utilizando UUID para evitar que a chave primária seja sequencial e previsível.

    protected $fillable = ['status'];

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'string';

    //relacionamento com produtos
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_sales')->withPivot('amount');

    }

    //método para calcular o valor total da venda
    public function getTotalAttribute() : float
    {
        return $this->products->sum(function ($product) {
            return $product->price * $product->pivot->amount;
        });
    }



}
