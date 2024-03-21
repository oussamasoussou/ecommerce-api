<?php

namespace App\Http\Requests\Categorie\SousSousCategorie;

use Illuminate\Foundation\Http\FormRequest;

class StoreSousSousCategorieRequest extends FormRequest
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
            'name' => 'string|required',
            'sousCategorieId' => 'nullable|exists:sous_categorie,id',
        ];
    }
}
