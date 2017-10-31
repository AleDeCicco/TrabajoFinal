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
	
	public function Vaciar ()
	{
		
		$this->saldo = 0;
		
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
		$pBoleto;
		$etiqueta;
		$bTransbordo;

		if( $transporte instanceof Bicicleta )
		{

			if( $lastDate )
			{

				if ( $lastDate->format('Y-m-d') != date('Y-m-d') )
				{

					if ( ( $this->saldo - ( 1.5 * $valor_boleto ) ) >= 0 )
					{
						$pBoleto=1.5;
						$etiqueta="MiBiciTuBici";
						$bTransbordo=1;
					}
					else
					{
						$pBoleto=0;
						$etiqueta="imposible";
						$bTransbordo=1;
					}
				} 
				else
				{
					$pBoleto=0;
					$etiqueta="MiBiciTuBici";
					$bTransbordo=1;
				}
			}
			else
			{
				$pBoleto=1.5;
				$etiqueta="MiBiciTuBici";
				$bTransbordo=1;
			}	
		}
		else
		{

			if ( $franquicia == 'medio' )
			{

				if ( $this->first )
				{

					if ( end($this->ViajesRealizados) >= $transbordo )
					{
						
						if ( ( $this->saldo - ( 0.5 * 0.3 * $valor_boleto ) ) >= 0 )
						{
							if (end($this->ViajesRealizados)
							    ->Transporte()->Nombre() != $transporte->Nombre(){
								    
								$pBoleto=0.5;
								$etiqueta="mediotransbordo";
								$bTransbordo=0.3;
							} else {
								
								if ( ( $this->saldo - ( 0.5 * $valor_boleto ) ) >= 0 ){
									$boleto=0.5;
									$etiqueta="medio";
									$bTransbordo = 1;
								} else {
								
									$pBoleto=0;
									$etiqueta="imposible";
									$bTransbordo=1;	
								}
							}
						}
						else
						{
							$pBoleto=0;
							$etiqueta="imposible";
							$bTransbordo=1;
						}	

					}
					else
					{
						
						if ( ( $this->saldo - ( 0.5 * $valor_boleto ) ) >= 0 )
						{

							$pBoleto=0.5;
							$etiqueta="medionormal";
							$bTransbordo=1;
						}
						else
						{
							$pBoleto=0;
							$etiqueta="imposible";
							$bTransbordo=1;
						}

					}

				}
				else
				{
					
					if ( ( $this->saldo - ( 0.5 * $valor_boleto ) ) >= 0 )
					{

						$pBoleto=0.5;
						$etiqueta="medionormal";
						$bTransbordo=1;
						$this->first = 1;

					}
					else
					{
						$pBoleto=0;
						$etiqueta="imposible";
						$bTransbordo=1;
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
							if (end($this->ViajesRealizados)
							    ->Transporte()->Nombre() != $transporte->Nombre(){
								    
								$pBoleto=1;
								$etiqueta="transbordo";
								$bTransbordo=0.3;
							} else {
								
								if ( ( $this->saldo - ( $valor_boleto ) ) >= 0 ){
									$boleto=1;
									$etiqueta="regular";
									$bTransbordo = 1;
								} else {
								
									$pBoleto=0;
									$etiqueta="imposible";
									$bTransbordo=1;	
								}
							}
						}
					}
					else
					{
						
						if ( ( $this->saldo - $valor_boleto ) >= 0 )
						{

							$pBoleto=1;
							$etiqueta="normal";
							$bTransbordo=1;

						}else
						{
							$pBoleto=0;
							$etiqueta="imposible";
							$bTransbordo=1;
						}

					}

				}
				else
				{
					
					if ( ( $this->saldo - $valor_boleto ) >= 0 )
					{

						$pBoleto=1;
						$etiqueta="normal";
						$bTransbordo=1;

					}else
					{
						$pBoleto=1;
						$etiqueta="imposible";
						$bTransbordo=1;
					}

				}

			} 
			elseif ( $franquicia == 'total' )
			{

				$pBoleto=0;
				$etiqueta="ftotal";
				$bTransbordo=1;

			}
			else
			{

				$pBoleto=0;
				$etiqueta="noexiste";
				$bTransbordo=1;

			}

		}
		if ($etiqueta == "imposible")
			echo "El saldo es insuficiente";
		elseif ($etiqueta == 'noexiste')
			echo "La franquicia no existe";
		else {
			$viaje_actual = new Viaje ($etiqueta , $pBoleto * $bTransbordo * $valor_boleto , $transporte , $tiempo );
			$this->saldo -= $pBoleto * $bTransbordo * $valor_boleto;
			array_push( $this->ViajesRealizados , $viaje_actual );
		} 
	}

	public function viajesRealizados()
	{
		return $this->ViajesRealizados;
	}
}
