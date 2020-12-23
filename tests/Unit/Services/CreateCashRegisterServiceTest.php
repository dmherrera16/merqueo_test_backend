<?php

namespace Tests\Unit\Services;

use App\Models\CashRegister;
use App\Services as Service;
use App\Repositories\CashRegisterRepositoryInterface;
use Tests\TestCase;

/**
 * Class CreateCashRegisterServiceTest
 * @package Tests\Unit\Services
 */
class CreateCashRegisterServiceTest extends TestCase
{
    /**
     * @test
     */
    public function createCashRegisterSuccessful(){

        $cashRegisterFactory = factory(CashRegister::class)->make()->toArray();

        $createCashRegisterRepositoryMock = \Mockery::mock(CashRegisterRepositoryInterface::class);
        $createCashRegisterRepositoryMock->shouldReceive('findByValueAndDenomination')
            ->once()
            ->with($cashRegisterFactory["denomination"], $cashRegisterFactory["value"])
            ->andReturn(null)
            ->getMock()
            ->shouldReceive('create')
            ->once()
            ->with($cashRegisterFactory)
            ->getMock();

        $createCashRegisterService = new Service\CreateCashRegisterService($createCashRegisterRepositoryMock);

        $response = $createCashRegisterService->create($cashRegisterFactory);

        $this->assertEquals(['message' => __('cash_register.create_success')], $response);

    }

    /**
     * @test
     */
    public function createCashRegisterAddingQuantitySuccessful(){

        $cashRegisterFactory = factory(CashRegister::class)->make();
        $cashRegisterFactoryArray = $cashRegisterFactory->toArray();

        $createCashRegisterRepositoryMock = \Mockery::mock(CashRegisterRepositoryInterface::class);
        $createCashRegisterRepositoryMock->shouldReceive('findByValueAndDenomination')
            ->once()
            ->with($cashRegisterFactory["denomination"], $cashRegisterFactory["value"])
            ->andReturn($cashRegisterFactory)
            ->getMock();

        $createCashRegisterService = new Service\CreateCashRegisterService($createCashRegisterRepositoryMock);

        $response = $createCashRegisterService->create($cashRegisterFactoryArray);

        $this->assertEquals(['message' => __('cash_register.create_success')], $response);

    }

    /**
     * @test
     */
    public function createCashRegisterExceptions(){
        $cashRegisterFactory = factory(CashRegister::class)->make();
        $cashRegisterFactoryArray = $cashRegisterFactory->toArray();

        $cashRegisterModelMock = \Mockery::mock(CashRegister::class);
        $cashRegisterModelMock->shouldReceive('getAttribute')
            ->andReturn(10)
            ->getMock()
            ->shouldReceive('setAttribute')
            ->getMock()
            ->shouldReceive('save')
            ->andReturn(false)
            ->getMock();

        $createCashRegisterRepositoryMock = \Mockery::mock(CashRegisterRepositoryInterface::class);
        $createCashRegisterRepositoryMock->shouldReceive('findByValueAndDenomination')
            ->once()
            ->with($cashRegisterFactory["denomination"], $cashRegisterFactory["value"])
            ->andReturn($cashRegisterModelMock)
            ->getMock();

        $createCashRegisterService = new Service\CreateCashRegisterService($createCashRegisterRepositoryMock);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(__('cash_register.create_failed'));
        $createCashRegisterService->create($cashRegisterFactoryArray);
    }
}
