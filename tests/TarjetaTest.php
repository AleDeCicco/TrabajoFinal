<?php

namespace TrabajoFinal;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {
	
	public function testRecarga()
	{

		$tarjeta0 = new Tarjeta();
		
		for ( $i=0 ; $i<=624 ; $i++ )
		{
		
			$tarjeta0->Recargar( $i );
			
			if ( $i == 332 )
			{
			
				$this->assertEquals( 388 , $tarjeta0->Saldo() );
			
			}elseif ( $i == 624 )
			{

				$this->assertEquals( 776 , $tarjeta0->Saldo() );

			}else
			{

				$this->assertEquals( $i , $tarjeta0->Saldo() );

			}
			
			$tarjeta0->Vaciar(); //Para que no acumule el saldo
		
		}

	}
	
	public function testPago()
	{

		$colectivo144Negro = new Colectivo( '144 Negro' , 'Rosario Bus' );
		$colectivo135 = new Colectivo( '135' , 'Rosario Bus' );
		$bici = new Bicicleta( 1234 , 'Bicicleta' );
		$bici = new Bicicleta( 5678 , 'Bicicleta' );

		$monto = 200;

		$tarjeta1 = new Tarjeta();
		$tarjeta1->recargar( $monto );

		//Regular misma línea

		$tarjeta1->pagar( $colectivo144Negro , '2016/06/30 22:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo144Negro , '2016/06/30 23:45' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio miama línea

		$tarjeta1->pagar( $colectivo144Negro , '2016/06/30 22:50' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo144Negro , '2016/06/30 23:45' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//total (franquicia jubilados) misma línea

		$tarjeta1->pagar( $colectivo144Negro , '2016/06/30 22:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo144Negro , '2016/06/30 23:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		///////////////////////////////////////////////////////////////////////

		//Regular diferentes líneas sin transbordo (>1hora)

		$tarjeta1->pagar( $colectivo144Negro , '2016/07/30 22:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo144Negro , '2016/07/30 23:55' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas sin transbordo(>1hora)

		$tarjeta1->pagar( $colectivo144Negro , '2016/07/30 22:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo144Negro , '2016/07/30 23:55' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta1->Saldo() );
		
		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas sin transbordo(>1hora)

		$tarjeta1->pagar( $colectivo144Negro , '2016/07/30 22:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo144Negro , '2016/07/30 23:55' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


	}
	
}
