<?php

namespace App\Http\Resources\Couleur;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouleurResource extends JsonResource
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
            "colorCode" => $this->colorCode,
        ];
    }
}
