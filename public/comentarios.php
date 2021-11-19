<?php
    // Takes raw data from the request
	$json = file_get_contents('php://input');

	// Converts it into a PHP object
	$data = json_decode($json);

 	if (!is_null($data))
	{
		$dbh = new PDO('mysql:host=localhost;dbname=smactiva', "root", "");
		$stmt = $dbh->prepare("INSERT into comentarios('nombre', 'email', 'telefono', 'asunto', 'comentario', 'fecha', 'visto') values
		    (?, ?, ?, ?, ?, ?, ?)");
		$stmt->bindParam(1, $data->nombre);
		$stmt->bindParam(2, $data->email);
		$stmt->bindParam(3, $data->telefono);
		$stmt->bindParam(4, $data->asunto);
		$stmt->bindParam(5, $data->comentario);
		$stmt->bindParam(6, );
		$stmt->bindParam(7, false);
		$stmt->execute();
		echo($stmt->rowCount());
	}
?>