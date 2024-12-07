<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class BaseRequest extends FormRequest
{
  /**
   * Http Status Code
   */
  protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;

  /**
  * Handle a failed validation attempt.
  *
  * @param  \Illuminate\Contracts\Validation\Validator  $validator
  *
  * @return void
  *
  * @throws HttpResponseException;
  */
  protected function failedValidation(Validator $validator)
  {
    $errors = [];
    foreach ($validator->getMessageBag()->toArray() as $key => $messages) {
      $errors[$key] = $messages[0];
    }
    throw new HttpResponseException(response()->json(
      [
        'status' => false,
        'code' => $this->code,
        'validationList' => $errors,
      ],
      $this->code
    ));
  }
}
