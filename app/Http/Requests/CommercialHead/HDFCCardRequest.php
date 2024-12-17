<?php
declare(strict_types=1);

namespace App\Http\Requests\CommercialHead;

use App\Http\Requests\BaseRequest;

class HDFCCardRequest extends BaseRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'file' => 'required|mimes:csv,xls,xlsx,XLS,XLSX|max:9048',
    ];
  }

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'file.required' => __('SBI Card file upload required'),
      'file.mimes' => __('SBI Card file upload only accepted csv,xls,xlsx'),
      'file.max' => __('SBI Card file upload max upload 9MB')
    ];
  }
}