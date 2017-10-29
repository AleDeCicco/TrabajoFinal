<?php

namespace TrabajoFinal;

class Tarjeta
{
	
	protected $saldo = 0;
	protected $ViajesRealizados = [];
	protected $first = 0; //En cuanto se haga el primer viaje no vale mas 0


	public function Recargar ( $monto )
	{
		if ( $monto == 332 )
		{

			$this->saldo += 388;

		}elseif( $monto == 624 )
		{

			$this->saldo += 776;

		}else
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

		$lastDate = (array_search(($transporte instanceof Bicicleta), array_reverse($ViajesRealizados)))->getDate();
		$today    = \DateTime::createFromFormat('!Y-m-d', date('Y-m-d'));

		$valor_boleto = 9.7;

		
		if( $transporte instanceof Bicicleta )
		{

			if ( $lastDate->format('Y-m-d') != date('Y-m-d') )
			{

				if ( ( $this->saldo - ( 1.5 * $valor_boleto ) ) >= 0 )
				{

					$viaje_actual = new Viaje("MiBiciTuBici",( 1.5 * $valor_boleto ),$transporte,$tiempo);
					$this->saldo -= ( 1.5 * $valor_boleto );	

				}else
				{

					echo "No tiene saldo suficiente";

				}

			}

			$viaje_actual = new Viaje("MiBiciTuBici",( 1.5 * $valor_boleto ),$transporte,$tiempo);			

		}else
		{

			if ( $franquicia == 'Medio' )
			{

				if ( $first )
				{

					if ( end($this->ViajesRealizados) >= $transbordo )
					{
						
						if ( ( $this->saldo - ( 0.5 * 0.3 * $valor_boleto ) ) >= 0 )
						{

							$viaje_actual = new Viaje("mediotransbordo",( 0.5 * 0.3 * $valor_boleto ),$transporte,$tiempo);
							$this->saldo -= ( 0.5 * 0.3 * $valor_boleto );	

						}else
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

						}else
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

			}elseif ( $franquicia == 'regular' )
			{

				if ( $first )
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

		array_push( $ViajesRealizados , $viaje_actual );
	}

	public function viajesRealizados()
	{
		return $ViajesRealizados;
	}
}
