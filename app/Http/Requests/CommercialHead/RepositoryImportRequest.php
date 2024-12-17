<?php
declare(strict_types=1);

namespace App\Http\Requests\CommercialHead;

use App\Http\Requests\BaseRequest;

class RepositoryImportRequest extends BaseRequest
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
      'repositoryFileUpload' => 'required|mimes:csv,xls,xlsx,doc,docx,PDF|max:9048',
      'dateImport' => 'required|date_format:Y-m-d',
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
      'repositoryFileUpload.required' => __('SBI Card file upload required'),
      'repositoryFileUpload.mimes' => __('SBI Card file upload only accepted csv,xls,xlsx,doc,docx,PDF'),
      'repositoryFileUpload.max' => __('SBI Card file upload max upload 9MB'),
      'dateImport.required' => __('Import date required'),
      'dateImport.required' => __('Import date format required')
    ];
  }
}