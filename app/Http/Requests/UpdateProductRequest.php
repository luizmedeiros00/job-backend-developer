<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
           'name'           => 'required|unique:products,name,' . $this->id,
           'price'          => 'required|numeric',
           'description'    => 'required',
           'category'       => 'required',
           'image_url'      => 'nullable|url'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'O nome é obrigatório',
            'name.unique'           => 'O nome ja existe',
            'price.required'        => 'O preço é obrigatório',
            'price.numeric'         => 'O preço deve ser do tipo numérico',
            'description.required'  => 'A descrição é obrigatória',
            'category.required'     => 'A categoria é obrigatória',
            'image_url.url'         => 'Image url inválida'
         ];
    }
}
