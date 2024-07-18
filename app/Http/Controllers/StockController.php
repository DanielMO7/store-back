<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    //
    public function getStock()
    {
        $consulta = new Stock();
        $resultado = $consulta->getStock();
        return $resultado;
    }

    public function createStock(Request $request)
    {
        $consulta = new Stock();
        $resultado = $consulta->createStock($request);
        return $resultado;
    }


}
