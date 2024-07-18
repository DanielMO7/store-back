<?php

namespace App\Http\Controllers;

use App\Models\Customer;


use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function getCustomer()
    {
        $consulta = new Customer();
        $resultado = $consulta->getCustomer();
        return $resultado;
    }

    public function createCustomer(Request $request)
    {
        $consulta = new Customer();
        $resultado = $consulta->createCustomer($request);
        return $resultado;
    }
}
