<?php

namespace TrabajoFinal;

class Tarjeta implements Inter_Tarjeta
{
	
	protected $saldo = 0;
	protected $ViajesRealizados = [];
	protected $first = 0; //En cuanto se haga el primer viaje no vale mas 0


	public function Recargar ( $monto )
	{
		if ( $monto == 332 )
		{
			$this->saldo += 388;
		}
		elseif( $monto == 624 )
		{
			$this->saldo += 776;
		}
		else
		{
			$this->saldo += $monto;
		}
	}

	public function Saldo ()
	{
		return $this->saldo;
	}
	
	public function Pagar (Transporte $transporte , $tiempo , $franquicia)
	{
		$transbordo = new \DateTime('now - 1 hour');

		$lastDate = False;

		$bicicleteo = array_search( ( $transporte instanceof Bicicleta ), array_reverse( $this->ViajesRealizados ) );
		if ( $bicicleteo )
		{
			$lastDate = ( $this-ViajesRealizados( $bicicleteo ) )->getDate();
		}

		
		$today    = \DateTime::createFromFormat('!Y-m-d', date('Y-m-d'));
		$valor_boleto = 9.7;
		
		if( $transporte instanceof Bicicleta )
		{

			if( $lastDate )
			{

				if ( $lastDate->format('Y-m-d') != date('Y-m-d') )
				{

					if ( ( $this->saldo - ( 1.5 * $valor_boleto ) ) >= 0 )
					{

						$viaje_actual = new Viaje("MiBiciTuBici",( 1.5 * $valor_boleto ),$transporte,$tiempo);
						$this->saldo -= ( 1.5 * $valor_boleto );	

					}
					else
					{

						echo "No tiene saldo suficiente";

					}

				} 
				else
				{
					$viaje_actual = new Viaje("MiBiciTuBici",0,$transporte,$tiempo); //viaje sin precio por ser del mismo dia
				}
			}
			else
			{
				$viaje_actual = new Viaje("MiBiciTuBici",( 1.5 * $valor_boleto ),$transporte,$tiempo);
			}	

		}
		else
		{

			if ( $franquicia == 'Medio' )
			{

				if ( $this->first )
				{

					if ( end($this->ViajesRealizados) >= $transbordo )
					{
						
						if ( ( $this->saldo - ( 0.5 * 0.3 * $valor_boleto ) ) >= 0 )
						{

							$viaje_actual = new Viaje("mediotransbordo",( 0.5 * 0.3 * $valor_boleto ),$transporte,$tiempo);
							$this->saldo -= ( 0.5 * 0.3 * $valor_boleto );	
						}
						else
						{
							echo "No tiene saldo suficiente";
						}	

					}
					else
					{
						
						if ( ( $this->saldo - ( 0.5 * $valor_boleto ) ) >= 0 )
						{

							$viaje_actual = new Viaje("medionormal",( 0.5 * $valor_boleto ),$transporte,$tiempo);
							$this->saldo -= ( 0.5 * $valor_boleto );
						}
						else
						{
							echo "No tiene saldo suficiente";
						}

					}

			}
			else
			{
				
				if ( ( $this->saldo - ( 0.5 * $valor_boleto ) ) >= 0 )
				{

					$viaje_actual = new Viaje("medionormal",( 0.5 * $valor_boleto ),$transporte,$tiempo);
					$this->saldo -= ( 0.5 * $valor_boleto );
					$this->first = 1;

				}else
				{

					echo "No tiene saldo suficiente";

				}

			}

			}
			elseif ( $franquicia == 'regular' )
			{

				if ( $this->first )
				{

				if ( end($this->ViajesRealizados) >= $transbordo )
				{
					
					if ( ( $this->saldo - ( 0.3 * $valor_boleto ) ) >= 0 )
					{

						$viaje_actual = new Viaje("transbordo",( 0.3 * $valor_boleto ),$transporte,$tiempo);
						$this->saldo -= ( 0.3 * $valor_boleto );

					}else
					{

						echo "No tiene saldo suficiente";

					}

				}
				else
				{
					
					if ( ( $this->saldo - $valor_boleto ) >= 0 )
					{

						$viaje_actual = new Viaje("normal",$valor_boleto,$transporte,$tiempo);
						$this->saldo -= $valor_boleto;

					}else
					{

						echo "No tiene saldo suficiente";

					}

				}

				}
				else
				{
					
					if ( ( $this->saldo - $valor_boleto ) >= 0 )
					{

						$viaje_actual = new Viaje("normal",$valor_boleto,$transporte,$tiempo);
						$this->saldo -= $valor_boleto;
						$this->first = 1;

					}else
					{

						echo "No tiene saldo suficiente";

					}

				}

			} elseif ( "franquicia" == 'total' )
			{

				$viaje_actual = new Viaje("ftotal",$valor_boleto,$transporte,$tiempo);

			}else
			{

				echo "El nombre de franquicia ingresado no corresponde a uno de los existentes";

			}

		}

		array_push( $this->ViajesRealizados , $viaje_actual );
	}

	public function viajesRealizados()
	{
		return $this->ViajesRealizados;
	}
}

/* //debug
$tarjeta = new Tarjeta;
$tarjeta->recargar( 272 );
echo $tarjeta->saldo();
$colectivo144Negro = new Colectivo( '144 Negro' , 'Rosario Bus' );
$tarjeta->pagar( $colectivo144Negro , '2016/06/30 22:50' , 'regular' );
$tarjeta->saldo();
$colectivo135 = new Colectivo( '135' , 'Rosario Bus' );
$tarjeta->pagar( $colectivo135 , '2016/06/30 23:10' , 'regular' );
$tarjeta->saldo();
$bici = new Bicicleta( 1234 , 'Bicicleta' );
$tarjeta->pagar( $bici , '2016/07/02 08:10' , 'regular' );
foreach ($tarjeta->viajesRealizados() as $viaje) {
 $viaje->tipo();
 $viaje->monto();
 $viaje->transporte()->nombre();
}
*/
