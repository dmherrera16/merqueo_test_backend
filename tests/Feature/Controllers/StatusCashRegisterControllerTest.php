<?php

namespace Tests\Feature\Controllers;

use App\Models\CashRegister;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatusCashRegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * This function test status cash register successful
     *
     * @test
     */
    public function getStatusCashRegisterSuccessful()
    {

        $dataCash1 = ["denomination" => "billete", "quantity" => 2, "value" => 50000];
        factory(CashRegister::class)->create($dataCash1);

        $dataCash2 = ["denomination" => "billete", "quantity" => 3, "value" => 10000];
        factory(CashRegister::class)->create($dataCash2);

        $dataCash3 = ["denomination" => "billete", "quantity" => 10, "value" => 5000];
        factory(CashRegister::class)->create($dataCash3);

        $response = $this->get(route('cashRegister.status'), ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('cash_register', $dataCash1);
        $response->assertJson(['cashRegister' => [$dataCash1, $dataCash2, $dataCash3]]);

    }
}
