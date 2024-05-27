<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\NewsController;
use App\Http\Requests\API\V1\News\CreateNewsRequest;
use App\Http\Requests\API\V1\News\UpdateNewsRequest;
use App\Http\Resources\API\V1\NewsResource;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class NewsControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new NewsController();
    }

    /** @test */
    public function it_can_add_news()
    {
        $user = Mockery::mock(\App\Models\User::class);
        $user->user_id = 1;
        Auth::shouldReceive('user')->andReturn($user);

        $request = Mockery::mock(CreateNewsRequest::class);
        $request->shouldReceive('validated')->andReturn([
            'title' => 'Test News',
            'content' => 'This is a test news article',
            'tags' => ['tag1', 'tag2'],
        ]);
        $request->shouldReceive('hasFile')->with('image')->andReturn(true);
        $request->shouldReceive('file')->with('image')->andReturn(new UploadedFile('path/to/image.jpg', 'image.jpg'));

        $newsData = new News([
            'title' => 'Test News',
            'content' => 'This is a test news article',
            'tags' => ['tag1', 'tag2'],
            'created_by' => 1,
        ]);

        News::shouldReceive('create')->once()->andReturn($newsData);
        $newsData->shouldReceive('addMediaFromRequest')->once()->andReturnSelf();
        $newsData->shouldReceive('toMediaCollection')->once()->andReturnSelf();

        $response = $this->controller->addNews($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new NewsResource($newsData))->response()->getData(true),
            $response->getData(true)
        );
    }

}
