<?php

namespace TrabajoFinal;

class Bicicleta extends Transporte
{
      public function __construct($nombre, $tipo)
      {
            $this->nombre = $nombre;
            $this->tipo = $tipo;
      }
}

