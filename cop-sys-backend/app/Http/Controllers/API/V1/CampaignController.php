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
    /**
     * @OA\Post(
     *     path="/api/v1/campaign",
     *     summary="Add a new campaign",
     *     tags={"Campaign"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateCampaignRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaign added successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CampaignResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
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
    /**
     * @OA\Put(
     *     path="/api/v1/campaign/{campaign}",
     *     summary="Update an existing campaign",
     *     tags={"Campaign"},
     *     @OA\Parameter(
     *         name="campaign",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCampaignRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaign updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CampaignResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaign not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

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

    /**
     * @OA\Delete(
     *     path="/api/v1/campaign/{campaign}",
     *     summary="Remove a campaign",
     *     tags={"Campaign"},
     *     @OA\Parameter(
     *         name="campaign",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaign deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaign not found"
     *     )
     * )
     */

    public function removeCampaign(Campaign $campaign): JsonResponse
    {
        $campaign->delete();

        return $this->respondWithSuccess(null, __('app.campaign.deleted'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/campaign",
     *     summary="Get all campaigns",
     *     tags={"Campaign"},
     *     @OA\Response(
     *         response=200,
     *         description="Campaigns list retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CampaignResource"))
     *     )
     * )
     */
    public function allCampaigns(): JsonResponse
    {
        $campaigns = Campaign::orderBy('created_at', 'desc')->paginate(8);

        return $this->respondWithSuccess(CampaignResource::collection($campaigns));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/campaign/{campaign}",
     *     summary="View a campaign by ID",
     *     tags={"Campaign"},
     *     @OA\Parameter(
     *         name="campaign",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaign retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CampaignResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaign not found"
     *     )
     * )
     */
    public function viewCampaign(Campaign $campaign): JsonResponse
    {
        return $this->respondWithSuccess(new CampaignResource($campaign));
    }
}
