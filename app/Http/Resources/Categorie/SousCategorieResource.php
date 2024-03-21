<?php

namespace App\Http\Resources\Categorie;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SousCategorieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "categorie" => new CategorieResource($this->categorie),
        ];
    }
}
