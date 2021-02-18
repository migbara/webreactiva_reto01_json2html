<?php


ini_set("error_reporting","E_ALL & ~E_NOTICE");


$json = '{"tag":"ul","children":[{"text":"Primer elemento"},{"text":"Cáspita, otro elemento","children":[{"tag":"ul","children":[{"text":"Primer heredero del cáspita"},{"text":"Último heredero del cáspita"}]}]},{"text":"El último"}]}';
//$json = json_encode($json,true);
//echo $json."\r\n";

function json2html($json,&$nivel,$spaces){
	$array = json_decode($json,true);
	
	//echo "<pre>"."\r\n";
	//echo $json."\r\n";
	//print_r($array);
	//echo "NIVEL: ".$nivel."\r\n";
	//echo "ESPACES: ".$spaces."\r\n";
	
	$cadena = "";
	
	//Recorremos el array
	foreach($array as $clave => $valor){
		if($clave=="tag"){
			$cadena .= str_repeat(" ",($nivel*$spaces))."<".$valor.">"."\r\n";
			$tag = $valor;
			//$nnivel = $nivel;
		}
		if($clave=="children"){
			foreach($valor as $k => $child){
				//print_r($child);
				foreach($child as $label => $contenido){
					$espacios = false;
					if($label == "text"){
						$cadena .= str_repeat(" ",(($nivel+1)*$spaces))."<li>".$contenido;
					}
					if($label == "children"){
						$espacios = true;
						foreach($contenido as $j => $cont){
							//$nivel++;
							$n = $nivel+2;
							$cadena .= "\r\n".json2html(json_encode($cont),$n,$spaces);
						}
					}
				}
				if($espacios)
					$cadena .= str_repeat(" ",(($nivel+1)*$spaces));
				$cadena .= "</li>"."\r\n";
			}
		}
	}
	$cadena .= str_repeat(" ",($nivel*$spaces))."</".$tag.">"."\r\n";
	
	return $cadena;
}
$nivel = 0;
$espacios = 4;
echo json2html($json,$nivel,4);


?>
