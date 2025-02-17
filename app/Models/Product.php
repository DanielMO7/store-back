<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class Product extends Model
{
    protected $table = 'products';
    use HasFactory;

    public function getProduct()
    {
        try {
            $customer = Product::all();

            return response()->json([
                'status' => 1,
                'msg' => 'Productos entregados correctamente',
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

    public function createProduct($request)
    {
        $validator = Validator::make($request->all(), [
            'Code' => 'required|string|unique:products,Code|max:255',
            'Name' => 'required|string|max:255',
            'Value' => 'required|numeric|between:0,999999.99',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json([
                'message' => 'Ha ocurrido un error de validación.',
                'errors' => $errors
            ], 422);
        }
        try {

            $book = new Product();
            $book->Code = $request->Code;
            $book->Name = $request->Name;
            $book->Value = $request->Value;
            $book->save();

            return response()->json([
                'status' => 1,
                'msg' => 'Producto creado correctamente',
                'data' => $book
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
