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

	// Declaración de Funciones
	function fetch($user_id, $site_id){
		$today = date('Y-m-d');
		$json = file_get_contents('https://api.mercadolibre.com/sites/'.$site_id.'/search?seller_id='.$user_id.'&search_type=scan');
		
		$log = fopen('.\\logs\\'.$today.'-articles-'.$user_id.'.log', "w");
		$json = json_decode($json, TRUE);
		$text = "----- START OF USER_ID : ".$user_id." DATA ------ \n";
		
		foreach($json['results'] as $value){
			$text .= 'id: '. $value['id']. ', title: '.$value['title'].', category_id: '.$value['category_id'];
			$jsoncategory = file_get_contents('https://api.mercadolibre.com/categories/'.$value['category_id']);
			$category = json_decode($jsoncategory, true);
			$text .= ', category_name: '.$category['name'];
			
			$text .= "\n";
		}
		$text .= "----------- END OF USER_ID: ".$user_id." DATA ---------- \n";
		fwrite($log, $text);
	}

	function search($user_id,  $site_id){

		if(is_array($user_id) && is_array($user_id['u'])){
			foreach($user_id['u'] as $user){
				fetch($user, $site_id);
			}
		}else{
			
			fetch($user_id['u'], $site_id);
		}
		
		
	}

	//LLamado de Funciones
	$users = getopt("u:");
	if($users){
		search($users, 'MLA');	
	}else{
		search(array('u' =>'179571326'), 'MLA');
	}
