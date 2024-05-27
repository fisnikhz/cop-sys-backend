<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\AttendanceController;
use App\Http\Requests\API\V1\Attendance\CreateAttendanceRequest;
use App\Http\Requests\API\V1\Attendance\UpdateAttendanceRequest;
use App\Models\Attendance;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class AttendanceControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new AttendanceController();
    }

    /** @test */
    public function it_can_add_attendance()
    {
        $data = [
            'personnel_id' => 1,
            'attendance_date' => '2024-01-01',
            'entry_time' => '08:00',
            'missed_entry' => 'No',
        ];

        $request = Mockery::mock(CreateAttendanceRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $attendance = Mockery::mock(Attendance::class);
        $attendance->shouldReceive('create')->with($data)->andReturn(new Attendance($data));
        $this->app->instance(Attendance::class, $attendance);

        $response = $this->controller->addAttendance($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_update_attendance()
    {
        $data = [
            'personnel_id' => 1,
            'attendance_date' => '2024-01-01',
            'entry_time' => '08:30',
            'missed_entry' => 'Yes',
        ];

        $request = Mockery::mock(UpdateAttendanceRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $attendance = Mockery::mock(Attendance::class);
        $attendance->shouldReceive('find')->with(1)->andReturnSelf();
        $attendance->shouldReceive('update')->with($data)->andReturnTrue();
        $this->app->instance(Attendance::class, $attendance);

        $response = $this->controller->updateAttendance($request, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_remove_attendance()
    {
        $attendance = Mockery::mock(Attendance::class);
        $attendance->shouldReceive('delete')->andReturnTrue();
        $this->app->instance(Attendance::class, $attendance);

        // Mock route model binding
        $route = Mockery::mock(\Illuminate\Routing\Route::class);
        $route->shouldReceive('parameter')->with('attendance')->andReturn($attendance);
        $this->app['router']->matched(function ($event) use ($route) {
            $event->route->setParameter('attendance', $route->parameter('attendance'));
        });

        $response = $this->controller->removeAttendance($attendance);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_get_attendance()
    {
        $attendance = Mockery::mock(Attendance::class);
        $attendance->attendance_id = 1;
        $attendance->shouldReceive('find')->with(1)->andReturnSelf();
        $attendance->shouldReceive('firstOrFail')->andReturnSelf();
        $this->app->instance(Attendance::class, $attendance);

        $response = $this->controller->getAttendance(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /** @test */
    public function it_can_get_all_attendances()
    {
        $attendance = Mockery::mock(Attendance::class);
        $attendance->shouldReceive('all')->andReturn(collect([]));
        $this->app->instance(Attendance::class, $attendance);

        $response = $this->controller->getAllAttendances();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }
}
