<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProduct()
    {
        $consulta = new Product();
        $resultado = $consulta->getProduct();
        return $resultado;
    }

    public function createProduct(Request $request)
    {
        $consulta = new Product();
        $resultado = $consulta->createProduct($request);
        return $resultado;
    }
}
