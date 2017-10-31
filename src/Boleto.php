<?php

namespace TrabajoFinal;

class Boleto
{

	protected $viaje;
	protected $tarjeta;

	public function __construct(Viaje $viaje, Tarjeta $tarjeta){

		$this->viaje = $viaje;
		$this->tarjeta = $tarjeta;
	}

	public function Viaje(){

		return $this->viaje;
	}


	public function Tarjeta(){

		return $this->tarjeta;
	}

	public function Imprimir(){

		$v = $this->viaje;
		$t = $this->tarjeta;

		return [ $v->Tiempo(),
			$v->Monto(),
			$v->Transporte(),
			$v->Tipo(),
			$t->Id(),
			$t->Saldo()
		];
	}
}
