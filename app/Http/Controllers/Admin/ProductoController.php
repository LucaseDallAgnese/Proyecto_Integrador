<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// El modelo 'Home' representará la tabla de productos en tu BD.
// Si tu tabla de productos se llama, por ejemplo, 'homes', Laravel la vinculará automáticamente.
// Si tu tabla se llama 'productos' o 'products', deberías especificarlo:
// protected $table = 'products';
class Home extends Model
{
    use HasFactory;

    // Define los campos que se pueden asignar masivamente [7]
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'imagen_url', // Asumiendo que guardas la URL de la imagen
    ];
}

class HomeController extends Controller
{
    public function index()
    {
        // Obtener todos los productos de la base de datos
        // Esto asume que tu tabla de productos está vinculada al modelo 'Home'
        $products = Home::all(); // Equivale a "SELECT * FROM tu_tabla_de_productos" [10]

        // También podrías usar paginación si tienes muchos productos:
        // $products = Home::paginate(12);

        // Retorna la vista 'home' y le pasa la variable $products [11]
        return view('home', compact('products'));
    }
}