<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Opcional, para borrado lógico [17, 18]

class Product extends Model
{
    use HasFactory, SoftDeletes; // Usar SoftDeletes si deseas borrado lógico

    // Nombre de la tabla si no sigue la convención de pluralización (ej. 'mis_productos') [24]
    // protected $table = 'products'; // Por defecto es 'products', no es necesario si sigues la convención

    // Campos que pueden ser asignados masivamente (para Product::create() y $product->update())
    protected $fillable = [ // [25]
        'name',
        'description',
        'price',
        'stock',
    ];

    // Opcional: si tienes atributos que siempre deben ser de un tipo específico
    protected $casts = [
        'price' => 'float',
        'stock' => 'integer',
    ];
}