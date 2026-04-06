<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'type'        => $this->data['type']        ?? 'default',
            'title'       => $this->data['title']       ?? '',
            'message'     => $this->data['message']     ?? '',
            'url'         => $this->data['url']          ?? null,
            'incident_id' => $this->data['incident_id'] ?? null,
            'pentest_id'  => $this->data['pentest_id']  ?? null,
            'is_read'     => !is_null($this->read_at),
            'created_at'  => $this->created_at,
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}
