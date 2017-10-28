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

		return $this->saldo;

	}

	public function Pagar ( Vehiculo $Vehiculo , $timestamp )
	{
		
	}

	public function viajesRealizados()
	{

		return $ViajesRealizados;
<?php
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
	
	public function Pagar (Transporte $t , $timestamp )
	{
	
		$viaje_actual = new Viaje;


		$viaje_actual->tiempo = $timestamp

		$viaje_actual->trans = $t;

		$viaje_actual->tipo = ??????????????????????

		$hoy = new \DateTime ('now');
		$transbordo = new \DateTime('1 hour');


		if ( first )
		{

			if ( ( $hoy - end($ViajesRealizados) ) <= transbordo )
			{

				$this->saldo -= 3.2;
				$viaje_actual->monto = 3.2;

			}else
			{

				$this->saldo -= 9.7;
				$viaje_actual->monto = 9.7;

			}

		}else
		{

			$this->saldo -= 9.7;
			$viaje_actual->monto = 9.7;
			$this->first = 1;

		}

	array_push( $ViajesRealizados , $viaje_actual );

	}

	public function viajesRealizados()
	{

		return $ViajesRealizados;

	}
}
	}

}
