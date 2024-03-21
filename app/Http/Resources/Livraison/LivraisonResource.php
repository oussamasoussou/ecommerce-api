<?php

namespace App\Http\Resources\Livraison;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LivraisonResource extends JsonResource
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
            "prix" => $this->prix,
            "description1" => $this->description1,
            "description2" => $this->description2,
        ];
    }
}
