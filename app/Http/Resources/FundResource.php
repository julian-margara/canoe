<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FundResource extends JsonResource
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
            'aliases' => $this->aliases->pluck('alias'),
            'start_year' => (int)$this->start_year,
            'fund_manager' => FundManagerResource::make($this->fundManager),
            'companies' => $this->companies->map->only('id', 'name')
        ];
    }
}
