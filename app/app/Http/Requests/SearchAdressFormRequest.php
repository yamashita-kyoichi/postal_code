<?php

namespace App\Http\Requests;

use App\Models\PostalCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SearchAdressFormRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;//TODO 認証
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
		$select_attributes = implode("|",PostalCode::$columns);
    return [
      'postal_code' => 'required|digits:7',
      'select' => ['required',
                  'regex:/^('.$select_attributes.')(,('.$select_attributes.'))*$/']
    ];
  }

  /**
   * [Override] バリデーション失敗時
   *
   * @param Validator $validator
   * @throw HttpResponseException
   *
   * @return void
   */
  protected function failedValidation( Validator $validator )
  {
    $response['data']    = [];
    $response['status']  = 'Failed';
    $response['summary'] = 'Failed validation.';
    $response['errors']  = $validator->errors()->toArray();

    throw new HttpResponseException(
      response()->json($response, 422)
    );
  }
}
