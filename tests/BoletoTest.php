<?php

namespace TrabajoFinal;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {

	public function testBoleto(){

		$tarjeta = new tarjeta(10);
		$array = $tarjeta->viajesRealizados();
		$boleto = new Boleto(end($array),$tarjeta);

		$this->assertEquals(end($array)->Tipo(),$boleto->viaje->Tipo());

		$this->assertEquals($tarjeta->Saldo(),$boleto->tarjeta->Saldo());

		$this->assertEquals(end($array)->Tipo(),$boleto->Viaje()->Tipo());

		$this->assertEquals($tarjeta->Saldo(),$boleto->Tarjeta()->Saldo());

	}

}
