<?php

namespace TrabajoFinal;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {
	
	public function testRecarga()
	{

		$tarjeta = new Tarjeta();
		
		for ( $i=0 ; $i<=624 ; $i++ )
		{
		
			$tarjeta->Recargar( $i );
			
			if ( $i == 332 )
			{
			
				$this->assertEquals( 388 , $tarjeta->Saldo() );
			
			}elseif ( $i == 624 )
			{

				$this->assertEquals( 776 , $tarjeta->Saldo() );

			}else
			{

				$this->assertEquals( $i , $tarjeta->Saldo() );

			}
			
			$tarjeta->Vaciar(); //Para que no acumule el saldo
		
		}

	}
	
	public function testPago()
	{

		$colectivo144Negro = new Colectivo( '144 Negro' , 'Rosario Bus' );
		$colectivo135 = new Colectivo( '135' , 'Rosario Bus' );
		$bici = new Bicicleta( 1234 , 'Bicicleta' );
		$bici = new Bicicleta( 5678 , 'Bicicleta' );

		$monto = 200

		$tarjeta = new Tarjeta();
		$tarjeta->recargar( $monto );

		$tarjeta->pagar( $colectivo144Negro , '2016/06/30 22:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta->Saldo() );

		$tarjeta->pagar( $colectivo144Negro , '2016/06/30 22:45' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta->Saldo() );

	}
	
}
