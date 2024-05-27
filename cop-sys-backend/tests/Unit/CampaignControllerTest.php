<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\CampaignController;
use App\Http\Requests\API\V1\Campaign\CreateCampaignRequest;
use App\Http\Requests\API\V1\Campaign\UpdateCampaignRequest;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class CampaignControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new CampaignController();
    }

    /** @test */
    public function it_can_add_campaign()
    {
        $data = [
            'title' => 'New Campaign',
        ];

        $request = Mockery::mock(CreateCampaignRequest::class);
        $request->shouldReceive('validated')->andReturn($data);
        $request->shouldReceive('hasFile')->with('pdf')->andReturn(false);

        $campaign = Mockery::mock(Campaign::class);
        $campaign->shouldReceive('create')->with($data)->andReturn(new Campaign($data));
        $this->app->instance(Campaign::class, $campaign);

        $response = $this->controller->addCampaign($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_update_campaign()
    {
        $data = [
            'title' => 'Updated Campaign',
        ];

        $request = Mockery::mock(UpdateCampaignRequest::class);
        $request->shouldReceive('validated')->andReturn($data);
        $request->shouldReceive('hasFile')->with('pdf')->andReturn(false);

        $campaign = Mockery::mock(Campaign::class);
        $campaign->shouldReceive('update')->with($data)->andReturnTrue();
        $this->app->instance(Campaign::class, $campaign);

        $response = $this->controller->updateCampaign($request, $campaign);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_remove_campaign()
    {
        $campaign = Mockery::mock(Campaign::class);
        $campaign->shouldReceive('delete')->andReturnTrue();
        $this->app->instance(Campaign::class, $campaign);

        $response = $this->controller->removeCampaign($campaign);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_view_campaign()
    {
        $campaign = Mockery::mock(Campaign::class);
        $this->app->instance(Campaign::class, $campaign);

        $response = $this->controller->viewCampaign($campaign);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_list_all_campaigns()
    {
        $campaign = Mockery::mock(Campaign::class);
        $campaign->shouldReceive('orderBy')->with('created_at', 'desc')->andReturnSelf();
        $campaign->shouldReceive('paginate')->with(8)->andReturn(collect([]));
        $this->app->instance(Campaign::class, $campaign);

        $response = $this->controller->allCampaigns();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }
}
