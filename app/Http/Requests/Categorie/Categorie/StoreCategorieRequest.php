<?php

namespace App\Http\Requests\Categorie\Categorie;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategorieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        return [
            'name' => 'required|string',
            // 'sousCategorieId' => 'nullable|exists:sous_categorie,id',
            // 'sousSousCategorieId' => 'nullable|exists:sous_sous_categorie,id',
        ];
    }
}
