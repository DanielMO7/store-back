<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class Stock extends Model
{
    protected $table = 'stock';
    use HasFactory;
    public function getStock()
    {
        try {
            $customer = Stock::all();

            return response()->json([
                'status' => 1,
                'msg' => 'Stock entregado correctamente',
                'data' => $customer
            ], 200);
        } catch (QueryException $e) {
            return  response()->json([
                'status' => 0,
                'msg' => 'Ha ocurrido un error interno.',
                'data' => $e
            ], 500);
        }
    }

    public function createStock($request)
    {
        $validator = Validator::make($request->all(), [
            'ProductID' => 'required|exists:products,id',
            'AmountStock' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json([
                'message' => 'Ha ocurrido un error de validación.',
                'errors' => $errors
            ], 422);
        }
        try {

            $existingStock = Stock::where('ProductID', $request->ProductID)->first();

            if ($existingStock) {
                $existingStock->AmountStock += $request->AmountStock;
                $existingStock->save();
            } else {
                $stock = new Stock();
                $stock->ProductID = $request->ProductID;
                $stock->AmountStock = $request->AmountStock;
                $stock->save();
            }

            // Respuesta de éxito
            return response()->json([
                'status' => 1,
                'msg' => 'Movimiento de stock realizado correctamente',
                'data' => $existingStock ? $existingStock : $stock
            ], 200);
        } catch (QueryException $e) {
            return  response()->json([
                'status' => 0,
                'msg' => 'Ha ocurrido un error interno.',
                'data' => $e
            ], 500);
        }
    }
}
