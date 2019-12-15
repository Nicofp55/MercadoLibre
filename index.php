<?php
	// Ejercicio - Investigación / Script
	// Cómo parte de nuestras tareas en soporte, tenemos la necesidad de consultar
	// información masivamente. Para poder agilizar estas tareas necesitamos construir un
	// script que nos permita realizar la siguiente tarea:
	
	// 1. Recorrer todos los ítems publicados por el seller_id = 179571326 del
	// site_id = "MLA"
	// 2. Generar un archivo de LOG que contenga los siguientes datos de
	// cada ítem:
	// a. "id" del ítem, "title" del item, "category_id" donde está
	// publicado, "name" de la categoría.
	
	// (*) Usar como ayuda el siguiente site http://developers.mercadolibre.com/
	// ● Tu tarea consiste en: construir el script en cualquier lenguaje de
	// programación para realizar lo anteriormente solicitado. Hacerlo de forma
	// genérica para poder re-utilizarlo con uno o múltiples users como entrada.
	// ● En el caso que no puedas resolverlo en algún lenguaje de programación,
	// detallar todas las APIs que encontraste y armar la estructura en
	// pseudocódigo.
	// Algunos requisitos:
	// ● El script debe estar subido a una cuenta de github para que todos podamos
	// descargarlo (pasar link).
	// ● Debe tener documentación explicando como usarlo.
	// ● Subir el file de output generado por el script
	function fetch($user_id, $site_id, $filename){

		$json = file_get_contents('https://api.mercadolibre.com/sites/'.$site_id.'/search?seller_id='.$user_id);
		$categories = file_get_contents('https://api.mercadolibre.com/sites/'.$site_id.'/categories');
		$categories = json_decode($categories, TRUE);
		$log = fopen($filename, "w");
		$json = json_decode($json, TRUE);
		$text = "----- START OF USER_ID : ".$user_id." DATA ------ \n";
		
		foreach($json['results'] as $value){
			$text .= 'id: '. $value['id']. ', title: '.$value['title'].', category_id: '.$value['category_id'];
			foreach($categories as $category){
				if($value['category_id'] === $category['id']){
					$text .= ', category_name: '.$category['name'];
				}
			}
			$text .= "\n";
		}
		$text .= "----------- END OF USER_ID: ".$user_id." DATA ---------- \n";
		fwrite($log, $text);
	}
	function search($user_id,  $site_id, $filename){
		
		if(is_array($user_id)){
			foreach($user_id as $user){
				fetch($user, $site_id, $filename);
			}
		}else{
			fetch($user_id, $site_id, $filename);
		}
		
		
	}
	search('179571326', 'MLA','./logs/articles.log');