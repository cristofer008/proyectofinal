<?php
	$mode = 0; //0 admin, 1 tecnico.
	$codigo = 0; //0 admin, 1 tecnico.
	$backlink = '/';

	if (empty($_GET))
		exit;

	if(isset($_GET['mode'])){
		$mode = $_GET['mode'];
	}

	if(isset($_GET['codigo'])){
		$codigo = $_GET['codigo'];
	}

	if(isset($_GET['b'])){
		$backlink = $_GET['b'];
		$backlink = base64_decode($backlink);
	}
	else
		exit;
	
	$dbh = new PDO('mysql:host=localhost;dbname=teleticket', "root", "");
	$stmt = $dbh->prepare(
 "SELECT *, usuarios.nombre AS cliente, tecnicos.nombre AS tecnico, tecnicos.email AS correo_tecnico, estados_tickets.estado AS estadodesc from tickets
	inner join usuarios on id_solicitante = usuarios.Id 
	inner join estados_tickets on estados_tickets.id_estado = tickets.estado 
	LEFT JOIN tecnicos ON tecnicos.id_tecnico = tickets.id_tecnico WHERE codigo = ?");
	$stmt->bindParam(1, $codigo);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if($result == false)
	{
		echo <<<EOT
		<!doctype html>
		<html lang="en"><head><title>Error</title></head>
		<body><p><b>No se ha encontrado un ticket con ese codigo </b></p><a href=$backlink>Volver</a></body></html> 
		EOT;
		exit;
	}
?>

<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="/styles/style.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

		<title>Editar ticket</title>
	</head>
	<body>
		<div class="container">
			<h2>Tele-Ticket</h2>
			<div class="row justify-content-end">
				<div class="col-auto">
					<?php echo '<a class="btn btn-primary" href="'.$backlink.'">Regresar</a>' ?>
				</div>
				<div class="col-auto">
					<a class="btn btn-primary" href="/index.php">Salir</a>
				</div>
			</div>
			<div class="container bg-light mb-4 p-2">
				<form>
					<p class="text-white bg-primary p-1">Encargado</p>
					<div class="container pb-2">
						<div class="mb-1">
							<div class="row justify-space-evenly">
								<div class="col">
									<label class="form-label">Nombre: <p id="nombreI">
										<?php
											if(!is_null($result['tecnico']))
												echo $result['tecnico'];
											else
												echo 'Sin asignar';
										?>
									</p></label>
								</div>
								<?php
								if($mode == 0)
									echo '
									<div class="col">
										<button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#asignarModal">Asignar encargado</button>
									</div>';
								?>
							</div>
						</div>
						<div class="mb-1">
							<label class="form-label">Correo: <p id="correoI"><?php echo $result['correo_tecnico'] ?></p></label>
						</div>
					</div>
					<p class="text-white bg-primary p-1">Cliente</p>
					<div class="container pb-2">
						<div class="mb-1">
							<label class="form-label">Nombre: <p>
								<?php
										echo $result['Nombre'];
								?>
							</p></label>
						</div>
						<div class="mb-1">
							<label class="form-label">Correo: <p><?php echo $result['Correo'] ?></p></label>
						</div>
					</div>
					<p class="text-white bg-primary p-1">Ticket</p>
					<div class="container pb-3">
						<div class="row justify-space-evenly">
							<div class ="col">
								<div class="mb-2">
									<label for="tituloI" class="form-label">Título</label>
									<?php
										echo '<input type="text" class="form-control" id="tituloI" value="'.$result['titulo'].'">';
									?>
								</div>
							</div>
							<div class ="col">
								<div class="mb-2">
									<label for="estadoI" class="form-label">Estado</label>
									<select class="form-select" id="estadoI" aria-label="Select">
										<?php
										$opciones = array("Abierto", "Asignado / Cerrado", "Resuelto (esperando aceptación)", "Resuelto", "Entrante");
										$vals = array(0,1,3,2,9);
										$max = 5;
										if($mode==1)
											$max = 3;

										for($i = 0; $i < $max; $i++)
										{
											echo '<option value="'.$vals[$i].'" ';
											if($vals[$i] == $result['id_estado'])
												echo 'selected';
											echo '>'.$opciones[$i].'</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="mb-2">
							<label for="fuenteI" class="form-label">Fuente</label>
							<select class="form-select" id="fuenteI" aria-label="Select">
								<?php
								$opciones = array("Telefono", "Correo", "Chat", "Formulario");
								$vals = array(0,1,2,3);
								for($i = 0; $i < count($opciones); $i++)
								{
									echo '<option value="'.$vals[$i].'" ';
									if($vals[$i] == $result['fuente'])
										echo 'selected';
									echo '>'.$opciones[$i].'</option>';
								}
								?>
							</select>
						</div>
						<div class="mb-2">
							<label for="temaI" class="form-label">Tema asociado</label>
							<?php
								echo '<input type="text" class="form-control" id="temaI" value="'.$result['tipo_problema'].'">';
							?>
						</div>
						<div class="mb-2">
							<label for="departamentoI" class="form-label">Departamento</label>
							<select class="form-select" id="departamentoI" aria-label="Select">
								<?php
								$opciones = array("Sin asignar", "Soporte", "Redes", "Servidores");
								$vals = array(-1,0,1,2);
								for($i = 0; $i < count($opciones); $i++)
								{
									echo '<option value="'.$vals[$i].'" ';
									if($vals[$i] == $result['departamento'])
										echo 'selected';
									echo '>'.$opciones[$i].'</option>';
								}
								?>
							</select>
						</div>
						<div class="mb-2">
							<label for="problemaI" class="form-label">Descripcion del problema</label>
							<textarea class="form-control" id="problemaI" row=3><?php echo $result['desc_problema'];?></textarea>
						</div>
						<div class="mb-2">
							<label for="respuestaI" class="form-label">Respuesta inicial</label>
							<textarea class="form-control" id="respuestaI" row=3><?php echo $result['resolucion_problema'];?></textarea>
						</div>
					</div>
					<p class="text-danger" id="errorO"></p>
					<button type="button" class="btn btn-primary" onClick="sendFun()">Guardar cambios</button>
				</form>
		</div>

		<div class="modal fade" id="asignarModal" tabindex="-1" aria-labelledby="asignarModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="asignarModalLabel">Asignar técnico</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
					<p class="lead">Buscar existente</p>
					<input type="search" id="tecnicoSearch" class="form-control mb-2" onInput="getTecnicos(this.value)"/>
					<ul class="list-group" id="listaTecnicos">

					</ul>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary" data-bs-dismiss="modal" onClick="removeTecnico()">Remover asignación</button>
					</div>
				</div>
			</div>
		</div>

		<script>
			function removeTecnico()
			{
				document.getElementById("nombreI").innerHTML = "Sin asignar";
				document.getElementById("correoI").innerHTML = "";
			}

			function asignarTecnico(nombre, correo)
			{
				document.getElementById("nombreI").innerHTML = nombre;
				document.getElementById("correoI").innerHTML = correo;
			}

			function getTecnicos(tecnico)
			{
				let obj = {tecnico: tecnico};

				let xhr = new XMLHttpRequest();
				xhr.open("POST", "/api/getTecnicos.php", true);
				xhr.onload = function (e) {
					if (xhr.readyState === 4) {
						if (xhr.status === 200) {
							let tecnicos = document.getElementById("listaTecnicos");
							tecnicos.textContent = '';
							let response = JSON.parse(xhr.response);
							for(var i = 0; i < response.length; i++)
							{
								let node = document.createElement("LI");
								node.setAttribute("class", "list-group-item list-group-item-action"); 
								node.setAttribute("onClick", 'asignarTecnico("'+response[i].nombre+'","'+response[i].email+'")');
								node.setAttribute("data-bs-dismiss", "modal");
								let textnode = document.createTextNode(response[i].nombre);
								node.appendChild(textnode);
								tecnicos.appendChild(node); 
							}
						} else {
							console.error(xhr.statusText);
						}
					}
				};
				xhr.onerror = function (e) {
					console.error(xhr.statusText);
				};
				xhr.send(JSON.stringify(obj));
			}
			getTecnicos("");

			function sendFun()
			{
				var obj = {
					nombre:       document.getElementById("nombreI").innerHTML,
					correo:       document.getElementById("correoI").innerHTML,
					titulo:       document.getElementById("tituloI").value,
					estado:       parseInt(document.getElementById("estadoI").value),
					fuente:       parseInt(document.getElementById("fuenteI").value),
					tema:         document.getElementById("temaI").value,
					departamento: parseInt(document.getElementById("departamentoI").value),
					respuesta:    document.getElementById("respuestaI").value,
					problema:     document.getElementById("problemaI").value,
					codigo: <?php echo $codigo; ?>
				};

				var xhr = new XMLHttpRequest();
				xhr.open("POST", "/api/ticketUpdate.php", true);
				xhr.onload = function (e) {
					if (xhr.readyState === 4) {
						if (xhr.status === 200) {
							console.log(xhr.response);
							window.location.href = <?php echo '"'.$backlink.'"'; ?> ;
						} else {
							console.error(xhr.statusText);
						}
					}
				};
				xhr.onerror = function (e) {
					console.error(xhr.statusText);
				};
				xhr.send(JSON.stringify(obj));
			}

		</script>
		<br><br><br>
		<!-- Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
	</body>
</html>
