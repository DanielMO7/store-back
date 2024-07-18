<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function getSale()
    {
        $consulta = new Sale();
        $resultado = $consulta->getSale();
        return $resultado;
    }

    public function createSale(Request $request)
    {
        $consulta = new Sale();
        $resultado = $consulta->createSale($request);
        return $resultado;
    }
}
