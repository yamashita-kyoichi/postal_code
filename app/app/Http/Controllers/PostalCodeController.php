<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchAdressFormRequest;
use App\Models\PostalCode;
use Illuminate\Http\Request;

class PostalCodeController extends Controller
{
  public function searchAdress(SearchAdressFormRequest $request) {
    try {
      $postal_code = $request->input('postal_code');
      $select = array_unique(explode(',', $request->input('select')));

      $adress_data = PostalCode::query()
                          ->wherePostalCode($postal_code)->get($select);

      $response_data['data']    = $adress_data;
      $response_data['status']  = 'Success';
      $response_data['summary'] = 'Success search adress.';
      $response_data['errors']  = '';
      return response()
              ->json($response_data, 200);

    } catch(\Exception $e) {
      $response_data['data']    = [];
      $response_data['status']  = 'Failed';
      $response_data['summary'] = 'Failed search adress.';
      $response_data['errors']  = $e->getMessage();
      return response()
              ->json($response_data, 422);
      
    }
  }
}
