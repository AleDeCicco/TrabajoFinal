<?php

namespace TrabajoFinal;

use PHPUnit\Framework\TestCase;

class TrabajoFinalTest extends TestCase {
	
	public function testRecarga()
	{

		$tarjeta = new Tarjeta;
		
		for ( $i=0 , $i<=624 , $i++ )
		{
		
			$tarjeta->recargar( $i );
			
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
			
			$this->assertEquals
		
		}

	}
	
}
