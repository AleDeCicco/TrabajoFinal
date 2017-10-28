class Bicicleta implements Transporte
{
      protected $nombre;
      protected $tipo;
  
      public function __construct($nombre, $tipo)
      {
            $this->nombre = $nombre;
            $this->tipo = $tipo;
      }
  
      public function Nombre()
      {
            return $this->nombre;
      }
 
      public function Tipo()
      {
            return $this->tipo;
      }
}
