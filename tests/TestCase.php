<?php

namespace Tests;

use App\Exceptions\Handler;
use App\User;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function asLoggedInUser($attributes = [])
    {
        $this->actingAs(factory(User::class)->create($attributes));

        return $this;
    }

    protected function assertSuccessfulRedirect($response)
    {
        $errors = app('session.store')->get('errors');
        if($errors) {
            $this->assertCount(0, $errors, 'Failed to pass validation for: ' . join(', ', $errors->keys()));
        }
        $this->assertEquals(302, $response->status(), 'Expected response status to be 302 for redirect');
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}

            public function report(Exception $e)
            {
                // no-op
            }

            public function render($request, Exception $e) {
                throw $e;
            }

//            public function renderForConsole($output, Exception $e) {};

        });
    }

    protected function assertModelDeleted($model)
    {
        return $this->assertNull($model->find($model->id));
    }
}
