<?php


class Tarjeta
{
	
	protected $saldo = 0;

	protected $ViajesRealizados = [];

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

		echo "El Saldo es: $this->saldo";

	}

	public function Pagar ( Vehiculo $Vehiculo , $timestamp )
	{



	}

	public function viajesRealizados()
	{



	}

}
