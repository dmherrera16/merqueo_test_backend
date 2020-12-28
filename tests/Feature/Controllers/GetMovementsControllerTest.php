<?php

namespace Tests\Feature\Controllers;

use App\Models\Movements;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetMovementsControllerTest extends TestCase
{
    /**
     * This function test get amount movement list by date
     *
     * @test
     */
    public function getListSuccessful()
    {

        $dataMovement = ['type' => 'ingreso', 'amount' => 30000, 'created_at' => '2020-12-25'];
        factory(Movements::class)->create($dataMovement);

        $dataMovement = ['type' => 'ingreso', 'amount' => 50000, 'created_at' => '2020-12-24'];
        factory(Movements::class)->create($dataMovement);

        $dataMovement = ['type' => 'ingreso', 'amount' => 40000, 'created_at' => '2020-12-24'];
        factory(Movements::class)->create($dataMovement);

        $response = $this->get(route('movement.getMovementsByDate', ['date' => '2020-12-27']), ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('movements', $dataMovement);

        $this->assertJson(json_encode(['amount' => 120000]));
    }
}
