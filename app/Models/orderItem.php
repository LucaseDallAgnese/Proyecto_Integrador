<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Convención: Nombre de clase y archivo en PascalCase (OrderItem)
class orderItem extends Model
{
    use HasFactory;

    /**
     * Relación: Un item de orden pertenece a una orden.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relación: Un item de orden pertenece a un producto.
     * ¡Esta es la función que soluciona el error!
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}