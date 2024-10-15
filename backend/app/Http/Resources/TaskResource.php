<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'finished_at' => [
                'date' => $this->finished_at,
                'friendly format' => ! empty($this->finished_at) ? Carbon::parse($this->finished_at)->format('d/m/Y H:i') : null,
            ],
        ];
    }
}
