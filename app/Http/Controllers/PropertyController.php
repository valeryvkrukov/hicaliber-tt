<?php

namespace App\Http\Controllers;

use Validator;
use App\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Search property
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price_min' => 'numeric',
            'price_max' => 'numeric',
            'bedrooms' => 'integer',
            'bathrooms' => 'integer',
            'storeys' => 'integer',
            'garages' => 'integer',
        ]);
        if (!$validator->fails()) {
            $data = Property::searchByParams($request->all())->get();
            return response()->json($data);
        } else {
            $errors = $validator->errors();
            return response()->json($errors->all(), 400);
        }
    }
}
