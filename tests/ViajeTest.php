<?php

namespace TrabajoFinal;

use PHPUnit\Framework\TestCase;

class ViajeTest extends TestCase
{
    public function testViajePlus()
    {
        $colectivo144Negro = new Colectivo('144 Negro', 'Rosario Bus');
        $colectivo135 = new Colectivo('135', 'Rosario Bus');
        $bici1234 = new Bicicleta(1234, 'Bicicleta');
        $bici5678 = new Bicicleta(5678, 'Bicicleta');

        $viaje = new Viaje('MiBiciTuBici', 9.7, $bici1234, '2017/08/19 21:00');

        $monto = 200;

        $tarjeta1 = new Tarjeta(1);
        $tarjeta1->recargar($monto);

        $this->assertEquals('MiBiciTuBici', $viaje->Tipo());
        $this->assertEquals(9.7, $viaje->Monto());
        $this->assertEquals($bici1234, $viaje->Transporte());
        $this->assertEquals('2017/08/19 21:00', $viaje->Tiempo());
    }
}

