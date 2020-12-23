<?php

namespace Tests\Feature\Controllers;

use App\Services\CreateCashRegisterServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class CreateCashRegisterControllerTest
 * @package Tests\Feature\Controllers
 */
class CreateCashRegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * This function test load register cash successful
     *
     * @test
     */
    public function createCashRegisterSuccess()
    {
        $data = [
            "denomination" => "billete",
            "quantity" => 10,
            "value" => 5000
        ];

        $response = $this->post(route("cashRegister.create"), $data, ['Accept' => 'application/json']);

        $response->assertStatus(201);
        $response->assertJson(['message' => __('cash_register.create_success')]);
        $this->assertDatabaseHas('cash_register', $data);
    }

    /**
     * This function test fail register cash
     * @test
     */
    public function createCashRegisterError()
    {
        $data = [
            "denomination" => "billete",
            "quantity" => 10,
            "value" => 5000
        ];

        $cashRegisterServiceMock = \Mockery::mock(CreateCashRegisterServiceInterface::class);
        $cashRegisterServiceMock->shouldReceive('create')
            ->once()
            ->with($data)
            ->andThrow(new \Exception('Error test'))
            ->getMock();

        $this->app->instance(CreateCashRegisterServiceInterface::class, $cashRegisterServiceMock);

        $response = $this->post(route("cashRegister.create"), $data, ['Accept' => 'application/json']);
        $response->assertStatus(500);
        $response->assertJson(['message' => 'Error test']);
    }

    /**
     * This function test validations load register cash
     *
     * @test
     */
    public function CreateCashRegisterValidations()
    {
        $response = $this->post(route("cashRegister.create"), [], ['Accept' => 'application/json']);
        $response->assertStatus(422);
        $response->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "denomination" => [
                        __('validation.required', ['attribute' => 'denomination'])
                    ],
                    "value" => [
                        __('validation.required', ['attribute' => 'value'])
                    ],
                    "quantity" => [
                        __('validation.required', ['attribute' => 'quantity'])
                    ]
                ]
            ]
        );
    }
}
