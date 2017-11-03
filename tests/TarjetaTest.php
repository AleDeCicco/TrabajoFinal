<?php

namespace TrabajoFinal;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {

	public function testId(){

		$tarjeta4 = new Tarjeta(4);

		$this->assertEquals( 4 , $tarjeta4->Id() );

	}

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

	public function testpago1()
	{

		$colectivo144Negro = new Colectivo( '144 Negro' , 'Rosario Bus' );
		$colectivo135 = new Colectivo( '135' , 'Rosario Bus' );
		$bici1234 = new Bicicleta( 1234 , 'Bicicleta' );
		$bici8765 = new Bicicleta( 5678 , 'Bicicleta' );

		$monto = 200;

		$tarjeta1 = new Tarjeta(1);
		$tarjeta1->recargar( $monto );

		/////////////////////////////////////////////////////////////////////*

		//Regular misma línea (Sin transbordo)

		$tarjeta1->Pagar( $colectivo144Negro , '2017/07/24 10:50' , 'regular' );

		$array = $tarjeta1->viajesRealizados();

		$this->assertEquals( $monto - 9.7 , $tarjeta1->Saldo() );

		$this->assertEquals('normal' , end($array)->Tipo());
		$this->assertEquals(9.7 , end($array)->Monto());
		$this->assertEquals($colectivo144Negro , end($array)->Transporte());
		$this->assertEquals('2017/07/24 10:50' , end($array)->Tiempo());

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

	}
	
	public function testPago2()
	{

		$colectivo153Negro = new Colectivo( '153Negro' , 'Rosario Bus' );
		$colectivo113 = new Colectivo( '113' , 'Rosario Bus' );
		$bici4321 = new Bicicleta( 4321 , 'Bicicleta' );
		$bici8765 = new Bicicleta( 8765 , 'Bicicleta' );

		$monto = 200;

		$tarjeta2 = new Tarjeta(2);
		$tarjeta2->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas sin transbordo (>60min) Lunes a viernes de 6 a 22

		$tarjeta2->Pagar( $colectivo153Negro , '2017/07/26 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/07/26 11:55' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Medio diferentes líneas sin transbordo (>60min) Lunes a viernes de 6 a 22

		$tarjeta2->Pagar( $colectivo153Negro , '2017/07/27 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/07/27 12:55' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Total diferentes líneas sin transbordo (>60min) Lunes a viernes de 6 a 22

		$tarjeta2->Pagar( $colectivo153Negro , '2017/07/28 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/07/28 13:55' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );


		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas con transbordo (<60min) Lunes a viernes de 6 a 22

		$tarjeta2->Pagar( $colectivo153Negro , '2017/07/31 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/07/31 11:45' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * ( 1 + 0.6 ) ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Medio diferentes líneas con transbordo (<60min) Lunes a viernes de 6 a 22

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/01 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/01 12:45' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * ( 0.5 + 0.5 * 0.6 ) ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Total diferentes líneas con transbordo (<60min) Lunes a viernes de 6 a 22

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/02 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/02 13:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );


		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );


		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas sin transbordo (>60min) Sábados de 6 a 14 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/05 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/05 11:55' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Medio diferentes líneas sin transbordo(>60min) Sábados de 6 a 14 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/05 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/05 12:55' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Total diferentes líneas sin transbordo(>60min) Sábados de 6 a 14 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/05 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/05 13:55' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );


		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		
		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas con transbordo (<60min) Sábados de 6 a 14 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/12 10:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/12 11:45' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * ( 1 + 0.6 ) ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Medio diferentes líneas con transbordo(<60min) Sábados de 6 a 14 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/12 11:50' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/12 12:45' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * ( 0.5 + 0.5 * 0.6 ) ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Total diferentes líneas con transbordo(<60min) Sábados de 6 a 14 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/12 12:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/12 13:45' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );


		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas con transbordo (<90min) Sábados de las 14 a 22 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/19 14:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/19 16:10' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * ( 1 + 0.6 ) ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Medio diferentes líneas con transbordo(<90min) Sábados de las 14 a 22 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/19 16:20' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/19 17:40' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * ( 0.5 + 0.5 * 0.6 ) ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Total diferentes líneas con transbordo(<90min) Sábados de las 14 a 22 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/19 17:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/19 19:10' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );


		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas sin transbordo (>90min) Sábados de las 14 a 22 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/19 19:20' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/19 21:00' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Medio diferentes líneas sin transbordo(>90min) Sábados de las 14 a 22 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/19 19:20' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/19 21:00' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Total diferentes líneas sin transbordo(>90min) Sábados de las 14 a 22 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/19 19:20' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/19 21:00' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );


		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas sin transbordo (>90min) Domingos de 6 a 22 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/20 19:20' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/20 21:00' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Medio diferentes líneas sin transbordo(>90min) Domingos de 6 a 22 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/20 19:20' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/20 21:00' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Total diferentes líneas sin transbordo(>90min) Domingos de 6 a 22 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/20 19:20' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/20 21:00' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );


		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );


		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas con transbordo (<90min) Domingos de 6 a 22 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/19 14:50' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/19 16:10' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * ( 1 + 0.6 ) ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Medio diferentes líneas con transbordo(<90min) Domingos de 6 a 22 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/19 16:20' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/19 17:40' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * ( 0.5 + 0.5 * 0.6 ) ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Total diferentes líneas con transbordo(<90min) Domingos de 6 a 22 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/19 17:50' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/19 19:10' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );


		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas con transbordo (<90min) Todos los dias 22 a 6 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/20 22:10' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/20 23:30' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * ( 1 + 0.6 ) ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Medio diferentes líneas con transbordo(<90min) Todos los dias 22 a 6 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/20 23:40' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/21 00:00' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * ( 0.5 + 0.5 * 0.6 ) ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Total diferentes líneas con transbordo(<90min) Todos los dias 22 a 6 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/21 00:10' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/21 01:30' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );


		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		///////////////////////////////////////////////////////////////////////*

		//Regular diferentes líneas sin transbordo (>90min) Todos los dias 22 a 6 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/21 22:10' , 'regular' );

		$this->assertEquals( $monto - 9.7 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/21 23:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 2 ) , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Medio diferentes líneas sin transbordo(>90min) Todos los dias 22 a 6 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/22 00:00' , 'medio' );

		$this->assertEquals( $monto - 9.7 * 0.5 , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/22 01:40' , 'medio' );

		$this->assertEquals( $monto - ( 9.7 * 0.5 ) * 2 , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Total diferentes líneas sin transbordo(>90min) Todos los dias 22 a 6 hs

		$tarjeta2->Pagar( $colectivo153Negro , '2017/08/22 02:20' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $colectivo113 , '2017/08/21 04:00' , 'total' );

		$this->assertEquals( $monto , $tarjeta2->Saldo() );


		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );



		// Bicis en días diferentes

		$tarjeta2->Pagar( $bici4321 , '2017/07/10 12:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $bici8765 , '2017/07/11 13:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) * 2 , $tarjeta2->Saldo() );

		$tarjeta2->Vaciar();
		$tarjeta2->recargar( $monto );

		//Bicis en el mismo día

		$tarjeta2->Pagar( $bici4321 , '2017/07/15 12:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) , $tarjeta2->Saldo() );

		$tarjeta2->Pagar( $bici8765 , '2017/07/15 13:50' , 'regular' );

		$this->assertEquals( $monto - ( 9.7 * 1.5 ) , $tarjeta2->Saldo() );

	}

	public function testViajesPlusPrimero(){

		////////////////////////////////////////////////////////////////

		//primer viaje comun (Plus)

		$colectivo153Negro = new Colectivo( '153Negro' , 'Rosario Bus' );
		$colectivo113 = new Colectivo( '113' , 'Rosario Bus' );

		$monto = 3;

		$tarjeta5 = new Tarjeta(5);
		$tarjeta5->recargar( $monto );

		$tarjeta5->Pagar($colectivo153Negro , '2017/07/15 13:50' , 'regular' );

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('viajeplus1' , end($array)->Tipo());

	}

	public function testViajesPlusPrimero2(){

		////////////////////////////////////////////////////////////////*

		//primer viaje medio boleto (Plus)

		$colectivo153Negro = new Colectivo( '153Negro' , 'Rosario Bus' );
		$colectivo113 = new Colectivo( '113' , 'Rosario Bus' );

		$monto = 3;

		$tarjeta6 = new Tarjeta(6);
		$tarjeta6->recargar($monto);

		$tarjeta6->Pagar($colectivo153Negro , '2017/07/15 13:50' , 'medio' );

		$array = $tarjeta6->viajesRealizados();

		$this->assertEquals('viajeplus1' , end($array)->Tipo());

		///////////////////////////////////////////////////////////////*

		//viaje comun plus

		$monto = 3;
		$tarjeta6->Vaciar();
		$tarjeta6->Cambiar($monto);

		$tarjeta6->Pagar($colectivo153Negro , '2017/07/15 16:50' , 'regular' );

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('viajeplus1' , end($array)->Tipo());

		///////////////////////////////////////////////////////////////*

		//viaje comun plus 2

		$tarjeta6->Pagar($colectivo113 , '2017/07/15 18:50' , 'regular' );

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('viajeplus2' , end($array)->Tipo());

		///////////////////////////////////////////////////////////////*

		//viaje comun plus 2

		$tarjeta6->Pagar($colectivo153Negro , '2017/07/15 19:00' , 'regular' );

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('imposible' , end($array)->Tipo());

		///////////////////////////////////////////////////////////////*

		//viaje medio plus

		$monto = 3;
		$tarjeta6->Vaciar();
		$tarjeta6->Cambiar($monto);

		$tarjeta6->Pagar($colectivo153Negro , '2017/07/15 20:30' , 'medio' );

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('viajeplus1' , end($array)->Tipo());

		///////////////////////////////////////////////////////////////*

		//viaje medio plus 2

		$tarjeta6->Pagar($colectivo113 , '2017/07/15 22:30' , 'medio' );

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('viajeplus2' , end($array)->Tipo());

		///////////////////////////////////////////////////////////////*

		//viaje transbordo regular

		$monto = 10;
		$tarjeta6->Vaciar();
		$tarjeta6->Cambiar($monto);

		$tarjeta6->Pagar($colectivo153Negro , '2017/07/16 19:40' , 'regular' );
		$tarjeta6->Pagar($colectivo113 , '2017/07/16 19:50' , 'regular');

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('viajeplus1' , end($array)->Tipo());

		$tarjeta6->Pagar($colectivo153Negro , '2017/07/16 20:00' , 'regular');

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('viajeplus2' , end($array)->Tipo());

		///////////////////////////////////////////////////////////////*

		//viaje transbordo medio

		$monto = 6;
		$tarjeta6->Vaciar();
		$tarjeta6->Cambiar($monto);

		$tarjeta6->Pagar($colectivo153Negro , '2017/07/17 19:40' , 'regular' );
		$tarjeta6->Pagar($colectivo113 , '2017/07/17 19:50' , 'regular');

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('viajeplus1' , end($array)->Tipo());

		$tarjeta6->Pagar($colectivo153Negro , '2017/07/17 20:00' , 'regular');

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('viajeplus2' , end($array)->Tipo());

		///////////////////////////////////////////////////////////////*

		//viaje que no puede ser transbordo entonces tambien es medio boleto (misma linea)

		$monto = 3;
		$tarjeta6->Vaciar();
		$tarjeta6->Cambiar($monto);

		$tarjeta6->Pagar($colectivo153Negro , '2017/07/16 11:30' , 'medio' );
		$tarjeta6->Pagar($colectivo153Negro , '2017/07/16 11:40' , 'medio' );

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('viajeplus1' , end($array)->Tipo());

		$tarjeta6->Pagar($colectivo153Negro , '2017/07/16 11:50' , 'medio' );

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('viajeplus2' , end($array)->Tipo());

		///////////////////////////////////////////////////////////////*

		//no existe etiqueta


		$tarjeta6->Pagar($colectivo153Negro , '2017/07/16 11:50' , 'medio' );

		$array = $tarjeta5->viajesRealizados();

		$this->assertEquals('noexiste' , end($array)->Tipo());


	}
	
}
