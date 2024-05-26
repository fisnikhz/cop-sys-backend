<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\Campaign\CreateCampaignRequest;
use App\Http\Requests\API\V1\Campaign\UpdateCampaignRequest;
use App\Http\Resources\API\V1\CampaignResource;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;

class CampaignController extends APIController
{
    public function addCampaign(CreateCampaignRequest $request): JsonResponse
    {
        $data = $request->validated();
        unset($data['pdf']);

        $campaign = Campaign::create($data);

        if ($request->hasFile('pdf')) {
            $campaign->addMediaFromRequest('pdf')
                ->toMediaCollection('pdfs');
        }

        return $this->respondWithSuccess(new CampaignResource($campaign));
    }

    public function updateCampaign(UpdateCampaignRequest $request, Campaign $campaign): JsonResponse
    {
        $data = $request->validated();

        $campaign->update($data);

        if ($request->hasFile('pdf')) {
            $campaign->clearMediaCollection('pdfs');
            $campaign->clearMediaCollection('thumbnails');
            $campaign->addMediaFromRequest('pdf')
                ->toMediaCollection('pdfs');
            $campaign->addMediaFromRequest('pdf')
                ->toMediaCollection('thumbnails', 'thumbnails');
        }

        return $this->respondWithSuccess(new CampaignResource($campaign));
    }

    public function removeCampaign(Campaign $campaign): JsonResponse
    {
        $campaign->delete();

        return $this->respondWithSuccess(null, __('app.campaign.deleted'));
    }

    public function allCampaigns(): JsonResponse
    {
        $campaigns = Campaign::orderBy('created_at', 'desc')->paginate(8);

        return $this->respondWithSuccess(CampaignResource::collection($campaigns));
    }

    public function viewCampaign(Campaign $campaign): JsonResponse
    {
        return $this->respondWithSuccess(new CampaignResource($campaign));
    }
}
