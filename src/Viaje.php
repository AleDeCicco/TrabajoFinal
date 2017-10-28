class V implements Viaje {
  
  protected $tipo;
  protected $monto;
  protected $transporte;
  
  public function __construct($tipo, $monto, $transporte)
  {
    $this->tipo = $tipo;
    $this->monto = $monto;
    $this->transporte = $transporte;
  }
  
  public function tipo()
  {
    return $this->tipo:
  }
  public function monto()
  {
    return $this->monto;
  }
  public function transporte()
  {
    return $this->transporte:
  }
}
