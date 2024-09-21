<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rules\Enum;
use App\Enums\MediaModelsEnum;
use Illuminate\Support\Str;

class StoreMediaRequest extends FormRequest
{
    
    /**
     * Summary of authorize
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $table = Str::camel($this->request->get("model", 'projects'));
        $rules =  [
            'model'=>[new Enum(MediaModelsEnum::class)],
            'model_id'=>'required|exists:'.$table.',id,deleted_at,NULL',
        ];

        //CHECK AND APPLY RULE IF FILES PARAMETER IS ARRAY 
        if(is_array($this->files->get('files'))){
            $rules['files'] = 'required';
            $rules['files.*'] = 'required|file|mimes:jpeg,jpg,png,gif,mp4,avi,mov,wmv|max:10240';
        }else{
            $rules['files'] = 'required|file|mimes:jpeg,jpg,png,gif,mp4,avi,mov,wmv|max:10240';
        }

        return $rules;
    }

    /**
     * Summary of failedValidation
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message'   => 'Validation errors',
            'data' => $validator->errors(),
        ],Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new HttpResponseException($response);
    }


}
