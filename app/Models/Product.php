<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Product extends Model
{
    use HasFactory;

    use HasUuids; //utilizando UUID para evitar que a chave primária seja sequencial e previsível.

    protected $fillable = ['name', 'price', 'description'];

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'string';

    //relacionamento com vendas
    public function sales()
    {
        return $this->belongsToMany(Sale::class)->withPivot('amount');
    }
}
