<?php

namespace Tests\Feature\Controllers;

use App\Models\CashRegister;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmptyCashRegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * This function test empty cash Register successful
     *
     * @test
     */
    public function emptyCashRegisterSuccessful()
    {
        $dataCash1 = ["denomination" => "billete", "quantity" => 2, "value" => 50000];
        factory(CashRegister::class)->create($dataCash1);

        $dataCash2 = ["denomination" => "billete", "quantity" => 3, "value" => 10000];
        factory(CashRegister::class)->create($dataCash2);

        $dataCash3 = ["denomination" => "billete", "quantity" => 10, "value" => 5000];
        factory(CashRegister::class)->create($dataCash3);

        $response = $this->post(route('cashRegister.empty'), ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('cash_register', [
            "denomination" => "billete",
            "quantity" => 0,
            "value" => 50000
        ]);
        $this->assertDatabaseHas('cash_register', [
            "denomination" => "billete",
            "quantity" => 0,
            "value" => 10000
        ]);
        $this->assertDatabaseHas('cash_register', [
            "denomination" => "billete",
            "quantity" => 0,
            "value" => 5000
        ]);

        $response->assertJson(['message' => __('cash_register.empty_successful')]);
    }
}
