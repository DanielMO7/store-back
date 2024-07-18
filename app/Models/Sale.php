<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class Sale extends Model
{
    protected $table = 'sales';
    use HasFactory;

    public function getSale()
    {
        try {
            $customer = Sale::all();

            return response()->json([
                'status' => 1,
                'msg' => 'Ventas entregadas correctamente',
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

    public function createSale($request)
    {
        $validator = Validator::make($request->all(), [
            'CustomerID' => 'required|exists:customers,id',
            'ProductID' => 'required|exists:products,id',
            'ProductValue' => 'required|numeric|between:0,999999.99',
            'Discount' => 'required|numeric|between:0,999999.99',
            'TotalSale' => 'required|numeric|between:0,999999.99',
            'Amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json([
                'message' => 'Ha ocurrido un error de validación.',
                'errors' => $errors
            ], 422);
        }
        try {

            $availableStock = Stock::where('ProductID', $request->ProductID)->value('AmountStock');

            if ($availableStock < $request->Amount) {
                return response()->json([
                    'message' => 'No hay suficiente stock disponible para realizar la venta.'
                ], 400);
            }

            $book = new Sale();
            $book->CustomerID = $request->CustomerID;
            $book->ProductID = $request->ProductID;
            $book->ProductValue = $request->ProductValue;
            $book->Discount = $request->Discount;
            $book->Amount = $request->Amount;
            $book->TotalSale = $request->TotalSale;
            $book->save();

            $newStock = $availableStock - $request->Amount;
            Stock::where('ProductID', $request->ProductID)->update(['AmountStock' => $newStock]);

            // Respuesta de éxito
            return response()->json([
                'status' => 1,
                'msg' => 'Venta creada correctamente',
                'data' => $book
            ], 201);
        } catch (QueryException $e) {
            return  response()->json([
                'status' => 0,
                'msg' => 'Ha ocurrido un error interno.',
                'data' => $e
            ], 500);
        }
    }
}
