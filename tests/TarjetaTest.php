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

		$tarjeta1->Pagar( $colectivo144Negro , '2017/07/24 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/07/24 11:45' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio misma línea (Sin transbordo)

		$tarjeta1->Pagar( $colectivo144Negro , '2017/07/25 11:50' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2016/07/25 12:45' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//total (franquicia jubilados) misma línea (Sin transbordo)

		$tarjeta1->Pagar( $colectivo144Negro , '2017/07/26 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo144Negro , '2017/07/26 13:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas sin transbordo (>60min) Lunes a viernes de 6 a 22

		$tarjeta1->Pagar( $colectivo144Negro , '2017/07/26 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/07/26 11:55' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas sin transbordo (>60min) Lunes a viernes de 6 a 22

		$tarjeta1->Pagar( $colectivo144Negro , '2017/07/27 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/07/27 12:55' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas sin transbordo (>60min) Lunes a viernes de 6 a 22

		$tarjeta1->Pagar( $colectivo144Negro , '2017/07/28 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/07/28 13:55' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas con transbordo (<60min) Lunes a viernes de 6 a 22

		$tarjeta1->Pagar( $colectivo144Negro , '2017/07/31 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/07/31 11:45' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * ( 1 + 0.6 ) ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas con transbordo (<60min) Lunes a viernes de 6 a 22

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/01 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/01 12:45' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * ( 0.5 + 0.5 * 0.6 ) ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas con transbordo (<60min) Lunes a viernes de 6 a 22

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/02 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/02 13:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );


		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas sin transbordo (>60min) Sábados de 6 a 14 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/05 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/05 11:55' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas sin transbordo(>60min) Sábados de 6 a 14 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/05 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/05 12:55' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas sin transbordo(>60min) Sábados de 6 a 14 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/05 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/05 13:55' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		
		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas con transbordo (<60min) Sábados de 6 a 14 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/12 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/12 11:45' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * ( 1 + 0.6 ) ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas con transbordo(<60min) Sábados de 6 a 14 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/12 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/12 12:45' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * ( 0.5 + 0.5 * 0.6 ) ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas con transbordo(<60min) Sábados de 6 a 14 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/12 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/12 13:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas con transbordo (<90min) Sábados de las 14 a 22 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/19 14:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/19 16:10' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * ( 1 + 0.6 ) ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas con transbordo(<90min) Sábados de las 14 a 22 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/19 16:20' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/19 17:40' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * ( 0.5 + 0.5 * 0.6 ) ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas con transbordo(<90min) Sábados de las 14 a 22 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/19 17:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/19 19:10' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas sin transbordo (>90min) Sábados de las 14 a 22 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/19 19:20' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/19 21:00' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Medio diferentes líneas sin transbordo(>90min) Sábados de las 14 a 22 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/19 19:20' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/19 21:00' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Total diferentes líneas sin transbordo(>90min) Sábados de las 14 a 22 hs

		$tarjeta1->Pagar( $colectivo144Negro , '2017/08/19 19:20' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $colectivo135 , '2017/08/19 21:00' , 'total' );

		$this->assertEquals( $monto , $tarjeta1->Saldo() );


		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );


		// Bicis en días diferentes

		$tarjeta1->Pagar( $bici1234 , '2017/07/10 12:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $bici5678 , '2017/07/11 13:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) * 2 , $tarjeta1->Saldo() );

		$tarjeta1->Vaciar();
		$tarjeta1->recargar( $monto );

		//Bicis en el mismo día

		$tarjeta1->Pagar( $bici1234 , '2017/07/15 12:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) , $tarjeta1->Saldo() );

		$tarjeta1->Pagar( $bici5678 , '2017/07/15 13:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) , $tarjeta1->Saldo() );

	}
	
}
