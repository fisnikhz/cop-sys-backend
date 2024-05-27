<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\MessageController;
use App\Http\Requests\API\V1\Message\CreateMessageRequest;
use App\Http\Resources\API\V1\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class MessageControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new MessageController();
    }

    /** @test */
    public function it_can_get_messages_for_a_conversation()
    {
        $conversation = Mockery::mock(Conversation::class);
        $messages = collect([
            new Message(['content' => 'Message 1']),
            new Message(['content' => 'Message 2']),
        ]);
        $conversation->shouldReceive('messages')->andReturn($messages);

        $response = $this->controller->index($conversation);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            MessageResource::collection($messages)->response()->getData(true),
            $response->getData(true)
        );
    }

    /** @test */
    public function it_can_create_a_message_for_a_conversation()
    {
        $conversation = Mockery::mock(Conversation::class);
        $request = Mockery::mock(CreateMessageRequest::class);
        $request->shouldReceive('input')->with('content')->andReturn('Test Message');

        Auth::shouldReceive('id')->andReturn(1);

        $message = new Message(['content' => 'Test Message']);
        $conversation->shouldReceive('messages')->andReturn($conversation);
        $conversation->shouldReceive('create')->andReturn($message);

        $response = $this->controller->store($request, $conversation);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new MessageResource($message))->response()->getData(true),
            $response->getData(true)
        );
    }
}
