<?php

namespace TrabajoFinal;

interface Tarjeta {
	 public function pagar(Transporte $transporte, $timestamp);
	 public function recargar($monto);
	 public function saldo();
	 public function viajesRealizados();
}
