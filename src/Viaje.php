class viaje implements Viaje 
{
      protected $tipo;
      protected $monto;
      protected $transporte;
      protected $tiempo;
  
      public function __construct($tipo, $monto, $transporte)
      {
            $this->tipo = $tipo;
            $this->monto = $monto;
            $this->transporte = $transporte;
      }
  
      public function Tipo()
      {
            return $this->tipo;
      }

      public function Monto()
      {
            return $this->monto;
      }

      public function Transporte()
      {
            return $this->transporte;
      }

      public function Tiempo()
      {
            return $this->tiempo;
      }
}
