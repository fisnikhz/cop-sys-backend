<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\ConversationController;
use App\Http\Resources\API\V1\ConversationResource;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class ConversationControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new ConversationController();
    }

    /** @test */
    public function it_can_get_admin_conversation()
    {
        $adminIds = [1, 2, 3];
        $userId = 4;

        $conversation = Mockery::mock(Conversation::class);

        Auth::shouldReceive('id')->andReturn($userId);

        User::shouldReceive('where')
            ->with('role', 1)
            ->andReturnSelf();
        User::shouldReceive('pluck')
            ->with('user_id')
            ->andReturn(collect($adminIds));

        Conversation::shouldReceive('whereHas')
            ->andReturnSelf();
        Conversation::shouldReceive('first')
            ->andReturn($conversation);

        if (!$conversation) {
            $conversation = new Conversation([
                'conversation_id' => (string) \Illuminate\Support\Str::uuid(),
                'conversation_name' => 'Chat with Admins',
                'conversation_picture' => 'default_picture.jpg'
            ]);

            Conversation::shouldReceive('create')
                ->with([
                    'conversation_id' => $conversation->conversation_id,
                    'conversation_name' => 'Chat with Admins',
                    'conversation_picture' => 'default_picture.jpg'
                ])
                ->andReturn($conversation);

            $conversation->shouldReceive('users')
                ->andReturnSelf();
            $conversation->shouldReceive('attach')
                ->with($adminIds)
                ->andReturnSelf();
            $conversation->shouldReceive('attach')
                ->with($userId)
                ->andReturnSelf();
        }

        $response = $this->controller->getAdminConversation();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(
            (new ConversationResource($conversation))->response()->getData(true),
            $response->getData(true)
        );
    }
}
