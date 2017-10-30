<?php

namespace TrabajoFinal;

interface Inter_Tarjeta {
	public function Pagar (Transporte $transporte , $tiempo , $franquicia);
	public function recargar($monto);
	public function saldo();
	public function viajesRealizados();
}
