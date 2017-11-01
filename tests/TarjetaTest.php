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

		/////////////////////////////////////////////////////////////////////*

		//Regular misma línea (Sin transbordo)

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 11:45' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio misma línea (Sin transbordo)

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 11:50' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2016/10/23 12:45' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//total (franquicia jubilados) misma línea (Sin transbordo)

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 13:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas sin transbordo (>60min) Lunes a viernes de 6 a 22

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 11:55' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas sin transbordo (>60min) Lunes a viernes de 6 a 22

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 12:55' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas sin transbordo (>60min) Lunes a viernes de 6 a 22

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 13:55' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas con transbordo (<60min) Lunes a viernes de 6 a 22

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 11:45' , 'regular' );

		$this->assertEquals( $monto - 9.7 ( 1 + 0.6 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas con transbordo (<60min) Lunes a viernes de 6 a 22

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 12:45' , 'medio' );

		$this->assertEquals( $monto - 9.7 * ( 0.5 + 0.5 * 0.6 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas con transbordo (<60min) Lunes a viernes de 6 a 22

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/23 13:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );


		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas sin transbordo (>60min) Sábados de 6 a 14 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/28 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/28 11:55' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas sin transbordo(>60min) Sábados de 6 a 14 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/28 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/28 12:55' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas sin transbordo(>60min) Sábados de 6 a 14 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/28 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/28 13:55' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		
		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas con transbordo (<60min) Sábados de 6 a 14 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/28 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/28 11:45' , 'regular' );

		$this->assertEquals( $monto - 9.7 ( 1 + 0.6 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas con transbordo(<60min) Sábados de 6 a 14 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/28 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/28 12:45' , 'medio' );

		$this->assertEquals( $monto - 9.7 * ( 0.5 + 0.5 * 0.6 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas con transbordo(<60min) Sábados de 6 a 14 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/28 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/10/28 13:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		// Bicis en días diferentes

		$tarjeta1->Pagar( $bici1234 , '2016/09/10 12:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $bici5678 , '2016/09/11 12:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Bicis en el mismo día

		$tarjeta1->Pagar( $bici1234 , '2016/09/15 12:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $bici5678 , '2016/09/15 12:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) , $tarjeta1->Saldo() );

	}
	
}
