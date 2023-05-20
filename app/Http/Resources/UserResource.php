<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'created_at' => $this->created_at->format('F jS, Y'),
            'updated_at' => $this->updated_at->format('F jS, Y'),
            'cars' => CarResource::collection($this->whenLoaded('cars')),
        ];
    }
}
