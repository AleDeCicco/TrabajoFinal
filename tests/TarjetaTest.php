<?php

namespace TrabajoFinal;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {
	
	public function testRecarga()
	{

		$tarjeta0 = new Tarjeta(0);
		
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
		$bici1234 = new Bicicleta( 1234 , 'Bicicleta' );
		$bici5678 = new Bicicleta( 5678 , 'Bicicleta' );

		$monto = 200;

		$tarjeta1 = new Tarjeta(1);
		$tarjeta1->recargar( $monto );


		//Regular misma línea (Sin transbordo)

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 11:45' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio misma línea (Sin transbordo)

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 11:50' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo144Negro , '2016/10/23 12:45' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//total (franquicia jubilados) misma línea (Sin transbordo)

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 13:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		///////////////////////////////////////////////////////////////////////

		//Regular diferentes líneas sin transbordo (>1hora)

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 11:55' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas sin transbordo(>1hora)

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 12:55' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas sin transbordo(>1hora)

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 13:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		///////////////////////////////////////////////////////////////////////

		//Regular diferentes líneas sin transbordo (Domingo)

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/22 22:40' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo135 , '2017/10/23 22:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas sin transbordo(Excede 90 min)

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 02:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo135 , '2017/10/23 04:30' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas sin transbordo(Fuera de horario)

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 05:20' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo135 , '2017/10/23 05:40' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		///////////////////////////////////////////////////////////////////////

		//Regular diferentes líneas con transbordo (<1hora)

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo135 , '2017/10/23 11:45' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 + 9.7 * 0.6 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas con transbordo(<1hora)

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo135 , '2017/10/23 12:45' , 'medio' );

		$this->assertEquals( $monto - 9.7 * ( 0.5 + 0.5 * 0.6 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas con transbordo(<1hora)

		$tarjeta1->pagar( $colectivo144Negro , '2017/10/23 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo135 , '2017/10/23 13:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		///////////////////////////////////////////////////////////////////////**

		//Regular + Transbordo + Regular

		$tarjeta1->pagar( $colectivo144Negro , '2016/09/30 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo135 , '2016/09/30 11:45' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 + 9.7 * 0.6 ) , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo135 , '2016/09/30 11:55' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 + 9.7 * 0.6 + 9.7) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio + Transbordo + Medio

		$tarjeta1->pagar( $colectivo144Negro , '2016/09/30 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo135 , '2016/09/30 12:45' , 'medio' );

		$this->assertEquals( $monto - 9.7 * ( 0.5 + 0.5 * 0.6 ) , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo135 , '2016/09/30 12:55' , 'medio' );

		$this->assertEquals( $monto - 9.7 * ( 0.5 + 0.5 * 0.6 + 0.5 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total + Transbordo + Total

		$tarjeta1->pagar( $colectivo144Negro , '2016/09/30 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo135 , '2016/09/30 13:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $colectivo135 , '2016/09/30 13:55' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		/////////////////////////////////////////////////////////////////

		//Boletos plus


		/////////////////////////////////////////////////////////////////

		// Bicis en días diferentes

		$tarjeta1->pagar( $bici1234 , '2016/09/10 12:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $bici5678 , '2016/09/11 12:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Bicis en el mismo día

		$tarjeta1->pagar( $bici1234 , '2016/09/15 12:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) , $tarjeta1->Saldo() );

		$tarjeta1->pagar( $bici5678 , '2016/09/15 12:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) , $tarjeta1->Saldo() );

	}
	
}
