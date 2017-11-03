<?php
namespace TrabajoFinal;
class Tarjeta implements Inter_Tarjeta
{
	
	protected $saldo;
	protected $ViajesRealizados = [];
	protected $first; //En cuanto se haga el primer viaje no vale mas 0
	protected $id;
	protected $plus;
	public function __construct($id){
		$this->saldo = 0;
		$this->first = 0;
		$this->id = $id;
		$this->plus = 0;
	}
	public function Recargar ( $monto )
	{
		if ( $monto == 332 )
		{
			$this->saldo += 388;
		}
		elseif( $monto == 624 )
		{
			$this->saldo += 776;
		}
		else
		{
			$this->saldo += $monto;
		}
		$this->saldo -= $this->plus * 9.7;
		$this->plus = 0;
	}
	
	public function Vaciar ()
	{
		
		$this->saldo = 0;
		$this->first = 0;
		$this->plus = 0;
		$this->ViajesRealizados = array();
		
	}
	
	public function Cambiar ($monto){

		$this->saldo = $monto;

	}
	
	public function Saldo ()
	{
		return $this->saldo;
	}
	public function viajesRealizados()
	{
		return $this->ViajesRealizados;
	}
	public function Id()
	{
		return $this->id;
	}
	
	public function pagar (Transporte $transporte , $tiempo , $franquicia)
	{
		
		$uViaje = false;
		$tiempoUViaje = false;
		
		for($i = sizeof($this->ViajesRealizados)-1 ; $i>=0 ; $i=$i-1){
			
			if ($this->ViajesRealizados[$i]->Transporte()->Tipo() != 'Bicicleta'){
				
				$uViaje = $this->ViajesRealizados[$i];
				break;
			}
		}
		
		if($uViaje){
			$tiempoUViaje = strtotime( $uViaje->Tiempo() );
		}
		$fecha = strtotime($tiempo);
		if ( intval(strftime('%w',$fecha)) == 6 
			&& intval(strftime('%H',$fecha)) < 22 
			&& intval(strftime('%H',$fecha)) >= 14 ){
			$tTransbordo = 5400;
		
		} elseif ( intval(strftime('%w',$fecha)) == 6 
			&& intval(strftime('%H',$fecha)) < 14 
			&& intval(strftime('%H',$fecha)) >= 6 ){
			$tTransbordo = 3600;
		
		} elseif ( intval(strftime('%w',$fecha)) == 0 
			&& intval(strftime('%H',$fecha)) < 22 
			&& intval(strftime('%H',$fecha)) >= 6 ){
			$tTransbordo = 5400;
		} elseif ( intval(strftime('%H',$fecha)) >= 22 || intval(strftime('%H',$fecha)) < 6 ){
			$tTransbordo = 5400;
		} elseif ( intval(strftime('%w',$fecha)) > 0 
			&& intval(strftime('%w',$fecha)) < 6
			&& intval(strftime('%H',$fecha)) < 22 
			&& intval(strftime('%H',$fecha)) >= 6 ){
			$tTransbordo = 3600;
		}
		if ( $tiempoUViaje && (($fecha - $tiempoUViaje) <= $tTransbordo))
			$pTransbordo = 0.6;
		else
			$pTransbordo = 1;
		$lastDate = False;
		$bicicleteo = false;
		for($i = sizeof($this->ViajesRealizados)-1 ; $i>=0 ; $i=$i-1){
			
			if ($this->ViajesRealizados[$i]->Transporte()->Tipo() == 'Bicicleta'){
				
				$bicicleteo = $this->ViajesRealizados[$i];
				break;
			}
		}
		
		if ( $bicicleteo )
		{
			$lastDate = $bicicleteo->Tiempo();
		}
		
		$valor_boleto = 9.7;
		$pBoleto;
		$etiqueta;
		$bTransbordo;
		if( $transporte->Tipo() == 'Bicicleta' )
		{
			if( $lastDate )
			{
				if ( $fecha - strtotime( $lastDate ) > 86400 )
				{
					if ( ( $this->saldo - ( 1.5 * $valor_boleto ) ) >= 0 )
					{
						$pBoleto=1.5;
						$etiqueta="MiBiciTuBici";
						$bTransbordo=1;
					}
					else
					{
						$pBoleto=0;
						$etiqueta="imposible";
						$bTransbordo=1;
					}
				} 
				else
				{
					$pBoleto=0;
					$etiqueta="MiBiciTuBici";
					$bTransbordo=1;
				}
			}
			else
			{
				$pBoleto=1.5;
				$etiqueta="MiBiciTuBici";
				$bTransbordo=1;
			}	
		}
		else
		{
			if ( $franquicia == 'medio' )
			{
				if ( $this->first )
				{
					if ( $pTransbordo == 0.6 )
					{
						
						if ( ( $this->saldo - ( 0.5 * $pTransbordo * $valor_boleto ) ) >= 0 )
						{
							if ($uViaje
							    ->Transporte()->Nombre() != $transporte->Nombre()){
								    
								$pBoleto=0.5;
								$etiqueta="mediotransbordo";
								$bTransbordo=$pTransbordo;
							} else {
								
								if ( ( $this->saldo - ( 0.5 * $valor_boleto ) ) >= 0 ){
									$pBoleto=0.5;
									$etiqueta="medio";
									$bTransbordo = 1;
								} else {
								
									if ( $this->plus == 0){
										
										$this->plus += 1;
										$pBoleto=1;
										$etiqueta="viajeplus1";
										$bTransbordo=1;
									}
								}
							}
						}
						else
						{
							if ( $this->plus == 0){
								
								$this->plus += 1;
								$pBoleto=1;
								$etiqueta="viajeplus1";
								$bTransbordo=1;
							} elseif ($this->plus == 1){
								$this->plus += 1;
								$pBoleto=1;
								$etiqueta="viajeplus2";
								$bTransbordo=1;
							} else{
								$pBoleto=0;
								$etiqueta="imposible";
								$bTransbordo=1;
							}
						}	
					}
					else
					{
						
						if ( ( $this->saldo - ( 0.5 * $valor_boleto ) ) >= 0 )
						{
							$pBoleto=0.5;
							$etiqueta="medionormal";
							$bTransbordo=1;
						}
						else
						{
							if ( $this->plus == 0){
								
								$this->plus += 1;
								$pBoleto=1;
								$etiqueta="viajeplus1";
								$bTransbordo=1;
							} elseif ($this->plus == 1){
								$this->plus += 1;
								$pBoleto=1;
								$etiqueta="viajeplus2";
								$bTransbordo=1;
							} else{
								$pBoleto=0;
								$etiqueta="imposible";
								$bTransbordo=1;
							}
						}
					}
				}
				else
				{
					
					if ( ( $this->saldo - ( 0.5 * $valor_boleto ) ) >= 0 )
					{
						$pBoleto=0.5;
						$etiqueta="medionormal";
						$bTransbordo=1;
						$this->first = 1;
					}
					else
					{
						if ( $this->plus == 0){
							
							$this->plus += 1;
							$pBoleto=1;
							$etiqueta="viajeplus1";
							$bTransbordo=1;
							$this->first = 1;
						} elseif ($this->plus == 1){
							$this->plus += 1;
							$pBoleto=1;
							$etiqueta="viajeplus2";
							$bTransbordo=1;
							$this->first = 1;
						} else{
							$pBoleto=0;
							$etiqueta="imposible";
							$bTransbordo=1;
						}
					}
				}
			}
			elseif ( $franquicia == 'regular' )
			{
				if ( $this->first )
				{
					if ( $pTransbordo == 0.6 )
					{
						if ( ( $this->saldo - ( $pTransbordo * $valor_boleto ) ) >= 0 )
						{
							if ($uViaje
							    ->Transporte()->Nombre() != $transporte->Nombre()){
								    
								$pBoleto=1;
								$etiqueta="transbordo";
								$bTransbordo=$pTransbordo;
							} else {
								
								if ( ( $this->saldo - ( $valor_boleto ) ) >= 0 ){
									$pBoleto=1;
									$etiqueta="regular";
									$bTransbordo = 1;
								} else {
								
									if ( $this->plus == 0){
										
										$this->plus += 1;
										$pBoleto=1;
										$etiqueta="viajeplus1";
										$bTransbordo=1;
										
									} elseif ($this->plus == 1) {
										$this->plus += 1;
										$pBoleto=1;
										$etiqueta="viajeplus2";
										$bTransbordo=1;
										
									} else{
										$pBoleto=0;
										$etiqueta="imposible";
										$bTransbordo=1;
									}
								}
							}
						}
					}
					else
					{
						
						if ( ( $this->saldo - $valor_boleto ) >= 0 )
						{
							$pBoleto=1;
							$etiqueta="normal";
							$bTransbordo=1;
						}else
						{
							if ( $this->plus == 0){
								
								$this->plus += 1;
								$pBoleto=1;
								$etiqueta="viajeplus1";
								$bTransbordo=1;
							} elseif ($this->plus == 1){
								$this->plus += 1;
								$pBoleto=1;
								$etiqueta="viajeplus2";
								$bTransbordo=1;
							} else{
								$pBoleto=0;
								$etiqueta="imposible";
								$bTransbordo=1;
							}
						}
					}
				}
				else
				{
					
					if ( ( $this->saldo - $valor_boleto ) >= 0 )
					{
						$pBoleto=1;
						$etiqueta="normal";
						$bTransbordo=1;
						$this->first = 1;
					} else {
						if ( $this->plus == 0){
							
							$this->plus += 1;
							$pBoleto=1;
							$etiqueta="viajeplus1";
							$bTransbordo=1;
							$this->first = 1;
						} elseif ($this->plus == 1) {
							$this->plus += 1;
							$pBoleto=1;
							$etiqueta="viajeplus2";
							$bTransbordo=1;
							$this->first = 1;
						} else{
							$pBoleto=0;
							$etiqueta="imposible";
							$bTransbordo=1;
						}
					}
				}
			} elseif ( $franquicia == 'total' )	{
				$pBoleto=0;
				$etiqueta="ftotal";
				$bTransbordo=1;
				$this->first = 1;
			} else {
				$pBoleto=0;
				$etiqueta="noexiste";
				$bTransbordo=1;
			}
		}
		if ($etiqueta == "imposible"){
		
			echo "El saldo es insuficiente";
			return false;
		} elseif ($etiqueta == 'noexiste'){
		
			echo "La franquicia no existe";
			return false;
		} else {
			
			if ($etiqueta != 'viajeplus1' && $etiqueta != 'viajeplus2'){
			
				$viaje_actual = new Viaje ($etiqueta , $pBoleto * $bTransbordo * $valor_boleto , $transporte , $tiempo);
				$this->saldo -= $pBoleto * $bTransbordo * $valor_boleto;
			} else {
				$viaje_actual = new Viaje ($etiqueta , $valor_boleto , $transporte , $tiempo);
			}
			
			array_push( $this->ViajesRealizados , $viaje_actual );
			//return new Boleto ( $viaje_actual , $this );
		} 
	}	
}
