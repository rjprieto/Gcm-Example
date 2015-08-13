<?php 
if (isset($_GET["regId"]) && isset($_GET["message"])) { 
    $regId = $_GET["regId"]; 
    $message = $_GET["message"]; 
     
    include_once 'GCM.php'; 
     
    $gcm = new GCM(); 

    $registatoin_ids = array($regId); 
    $mensaje = array( 
		'message'     => $message, //mensaje a enviar 
		'title'      => 'PushNotification',// Titulo de la notificaci�n 
		'msgcnt'    => '3',/*N�mero que sirve para informar cantidad de mensajes o eventos. 
										   Se muestra en la parte derecha de la notificaci�n 
										(En Android 2.3.6 no me lo muestra, me imagino que debe depender de la versi�n)*/ 
							  //'soundname'  => 'sonido.wav',//Sonido a reproducir *debe estar en la carpeta ra�z 
							  //'collapseKey' => 'demo', 
								/*Texto que sirve para colapsar las notificaciones cuando el dispositivo esta offline. 
								Esto detecta si el dispositivo estaba sin acceso a red, 
								de tal manera que una vez este en l�nea no le lleguen un mont�n 
								de notificaciones al tiempo; solo llegar� la �ltima de cada notificaci�n 
								que tenga el mismo collapseKey*/ 
	  'timeToLive' => 3000,/* Tiempo en segundos para mantener la notificaci�n en GMC 
				  y volver a intentar el env�o de esta. 
				  Default 4 semanas (2,419,200 segundos) si no es especificado.*/ 
  //'delayWhileIdle' => true, //Default is false 
  //Mas opciones en http://developer.android.com/google/gcm/server.html#params 
  ); 

    $result = $gcm->send_notification($registatoin_ids, $mensaje); 
	echo $result; 
	
} 
?>
