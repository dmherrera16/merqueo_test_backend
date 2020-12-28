<?php

namespace Tests\Feature\Controllers;

use App\Models\CashRegister;
use App\Models\Movements;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Class GetAllMovementsControllerTest
 * @package Tests\Feature\Controllers
 */
class GetAllMovementsControllerTest extends TestCase
{
    /**
     * This function test get movement list successful
     *
     * @test
     */
    public function getListSuccessful(){

        $dataMovement = ['type' => 'ingreso', 'amount' => 30000, 'created_at' => '2020-12-25'];
        factory(Movements::class)->create($dataMovement);

        $response = $this->get(route('movement.getAllMovements'), [], ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('movements', $dataMovement);

        $movements = Movements::all();
        $this->assertJson(json_encode(['movements' => [
            'id' => $movements->first()->id,
            'date' => $movements->first()->created_at,
            'amount' => $movements->first()->amount,
        ]]));
    }
}
