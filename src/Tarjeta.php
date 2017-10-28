<?php

namespace TrabajoFinal;

class Tarjeta
{
	
	protected $saldo = 0;
	protected $ViajesRealizados = [];
	protected first = 0: //En cuanto se haga el primer viaje no vale mas 0


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
	
	public function Pagar (Transporte $transporte , $tiempo )
	{
		$transbordo = new \DateTime('now - 1 hour');

		if ( $first )
		{

			if ( end($this->ViajesRealizados) >= $transbordo )
			{
				$viaje_actual = new Viaje("transbordo",3.2,$transporte,$tiempo);
				$this->saldo -= 3.2;

			}
			else
			{
				$viaje_actual = new Viaje("normal",9.7,$transporte,$tiempo);
				$this->saldo -= 9.7;
			}

		}
		else
		{
			$viaje_actual = new Viaje("normal",9.7,$transporte,$tiempo);
			$this->saldo -= 9.7;
			$this->first = 1;
		}

		array_push( $ViajesRealizados , $viaje_actual );
	}

	public function viajesRealizados()
	{
		return $ViajesRealizados;
	}
}
