<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'Name',
        'LastName',
        'Identification',
        'Email',
        'PhoneNumber',
    ];

    public function getCustomer()
    {
        try {
            $customer = Customer::all();

            return response()->json([
                'status' => 1,
                'msg' => 'Clientes entregados correctamente',
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

    public function createCustomer($request)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required|string|max:255',
            'LastName' => 'nullable|string|max:255',
            'Identification' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:customers',
            'PhoneNumber' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json([
                'message' => 'Ha ocurrido un error de validación.',
                'errors' => $errors
            ], 422);
        }
        try {

            $book = new Customer();
            $book->Name = $request->Name;
            $book->LastName = $request->LastName;
            $book->Identification = $request->Identification;
            $book->Email = $request->Email;
            $book->PhoneNumber = $request->PhoneNumber;
            $book->save();

            return response()->json([
                'status' => 1,
                'msg' => 'Customer creado correctamente',
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


    use HasFactory;
}
