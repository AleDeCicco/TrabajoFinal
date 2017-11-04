<?php

namespace TrabajoFinal;

interface Inter_Boleto{

	public function __construct(Viaje $viaje, Tarjeta $tarjeta);
	public function Viaje();
	public function Tarjeta();
	public function Imprimir();

}
