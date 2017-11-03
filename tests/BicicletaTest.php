<?php

namespace TrabajoFinal;

use PHPUnit\Framework\TestCase;

class BicicletaTest extends TestCase {

	public function testBicicleta()
	{

		$nombre = '1234';
		$tipo = 'Bicicleta';

		$bici = new Bicicleta($nombre,$tipo);

		$this->assertEquals( '1234' , $bici->nombre() );
		$this->assertEquals( 'Bicicleta' , $bici->tipo() );

		
	}

}
