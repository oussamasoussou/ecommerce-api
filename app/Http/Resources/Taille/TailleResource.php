<?php

namespace App\Http\Resources\Taille;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TailleResource extends JsonResource
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
            "size" => $this->size,
        ];
    }
}
