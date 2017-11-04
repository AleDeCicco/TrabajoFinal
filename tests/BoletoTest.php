<?php

namespace TrabajoFinal;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {

	public function testBoleto(){

		$tarjeta = new Tarjeta(10);
		
		$tipo = 'regular';
		$monto = 9.7;
		$colectivo = new Colectivo('Colectivo144Negro','Rosario Bus');
		$tiempo = '2017/11/03 11:50';
		
		$viaje = new Viaje ($tipo,$monto,$colectivo,$tiempo);
		
		$boleto = new Boleto($viaje,$tarjeta);
		
		$array = $tarjeta->viajesRealizados();

		$this->assertEquals($tipo,$boleto->Viaje()->Tipo());

		$this->assertEquals($tarjeta->Id(),$boleto->Tarjeta()->Id());
		
		$array = $boleto->Imprimir();
		
		$this->assertEquals($array[0],$boleto->Viaje()->Tiempo());
		$this->assertEquals($array[1],$boleto->Viaje()->Monto());
		$t = $array[2];
		$this->assertEquals($t->Nombre(),$boleto->Viaje()->Transporte()->Nombre());
		$this->assertEquals($array[3],$boleto->Viaje()->Tipo());
		$this->assertEquals($array[4],$boleto->Tarjeta()->Id());
		$this->assertEquals($array[5],$boleto->Tarjeta()->Saldo());
	}

}
