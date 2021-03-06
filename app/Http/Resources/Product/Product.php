<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (double)$this->price,
            'image' => $this->image,
            'categoriesStr' => $this->categoriesStr,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
