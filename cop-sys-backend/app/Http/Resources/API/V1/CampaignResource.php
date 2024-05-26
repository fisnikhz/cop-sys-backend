<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'campaign_id' => $this->campaign_id,
            'title' => $this->title,
            'description' => $this->description,
            'pdf_url' => $this->getFirstMediaUrl('pdfs'),
            'thumbnail_url' => $this->getFirstMediaUrl('thumbnail_campaigns'),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

}
