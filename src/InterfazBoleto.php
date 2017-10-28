<?php

namespace TrabajoFinal;

interface Boleto {
	 public function infoBoleto($numero_serie); //muestra información del boleto (Su fecha, El tipo de boleto (Normal, Plus, Medio), el saldo de la tarjeta. El numero de linea y el ID de la tarjeta.)
}
