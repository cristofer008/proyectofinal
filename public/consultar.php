<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="/styles/style.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

		<title>Teleticket</title>
	</head>
	<body>

		<div class="container">
			<h2>Teleticket</h2>
			<div class="row justify-content-end">
				<div class="col-auto">
					<a class="btn btn-primary" href="/">Regresar</a>
				</div>
				
			</div>

			<div class="container bg-light mb-4 mt-2 p-2 border">
				<p class="text-white bg-primary p-1">Consulta de solicitud</p>
				<p class="text-muted text-center">Para consultar el estado de su solicitud, ingrese la dirección de correo electronico con la cual realizó la misma.</p>
				<div class="mb-3">
					<label for="correoI" class="form-label">Correo electrónico</label>
					<input type="email" class="form-control" id="correoI"  onChange="consultar()">
				</div>
				<div class="row mx-auto" style="overflow:hidden;">
					<div class="col-2 d-inline mx-auto " >
						<button type="button" class="btn btn-primary d-block mx-auto" onClick="consultar()">Consultar</button>
					</div>
					<div class="col-10 d-inline p-0 m-0"  id="errorO">
					</div>
				</div>
				<?php
					if (!empty($_GET) && isset($_GET['mail']))
					{
						$dbh = new PDO('mysql:host=localhost;dbname=teleticket', "root", "");
						$stmt = $dbh->prepare(
						"SELECT * from usuarios WHERE Correo = ?");
						$stmt->bindParam(1, $_GET['mail']);
						$stmt->execute();
						if($stmt->rowCount() > 0)
						{
							$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
							echo <<<EOT
							<p class="text-white bg-primary p-1 mt-4 mb-2">Resultados de la consulta</p>
							<div class="row align-items-center mb-1">
								<div class="col-3 fw-bold">Cliente:</div>
								<div class="col">{$usuario["Nombre"]}</div>
							</div>
							<div class="row align-items-center mb-1">
								<div class="col-3 fw-bold">Correo:</div>
								<div class="col">{$usuario["Correo"]}</div>
							</div>
							<div class="row align-items-center mb-1">
								<div class="col-3 fw-bold">Teléfono:</div>
								<div class="col">{$usuario["Telefono"]}</div>
							</div>
							EOT;
						}
						$stmt = $dbh->prepare(
						"SELECT *, usuarios.nombre AS cliente, tecnicos.nombre AS tecnico, tecnicos.email AS correo_tecnico, estados_tickets.estado AS estadodesc
						from tickets
						inner join usuarios on id_solicitante = usuarios.Id 
						inner join estados_tickets on estados_tickets.id_estado = tickets.estado 
						LEFT JOIN tecnicos ON tecnicos.id_tecnico = tickets.id_tecnico WHERE Correo = ?");
						$stmt->bindParam(1, $_GET['mail']);
						$stmt->execute();
						if($stmt->rowCount() > 0)
						{
							?>
							<table class="table table-striped mt-4">
								<thead>
									<tr>
										<th class="text-center col" scope="col">Codigo</th>
										<th class="text-center col" scope="col">Fecha</th>
										<th class="text-center col" scope="col">Estado</th>
										<th class="text-center col" scope="col">Encargado</th>
										<th class="text-center col" scope="col">Detalles</th>
									</tr>
								</thead>
								<tbody id="resultsTable">
									<?php
									foreach($stmt as $row)
									{
										echo '<tr>';
										echo '<td class=\'text-center border\'>'. $row['codigo'] .'</td>';
										echo '<td class=\'text-center border\'>'. $row['fecha'] .'</td>';
										echo '<td class=\'text-center border\'>'. $row['estadodesc'] .'</td>';
										if(!is_null($row['tecnico']))
											echo '<td class=\'text-center border\'>'. $row['tecnico'] .'</td>';
										else
											echo '<td class=\'text-center border\'>Sin asignar</td>';
										echo '<td class=\'text-center border\'> <a class="text-decoration-none cursorClickIcon" onClick="detalles('.$row['codigo'].')">Ver detalles</a></td>';
										echo '</tr>';
									}
									?>
								</tbody>
							</table>
							<?php
						}
						else
						{
							echo '<hr><p class="fs-4 mt-4">No se encuentran solicitudes para este correo.</p>';
						}
					}
				?>
			</div>
		</div>
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header text-center border">
						<h5 class="modal-title border mx-auto" id="exampleModalLabel">Detalles del ticket</h5>
						<button type="button" class="btn-close border" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="row align-items-center mb-1">
							<div class="col-3 fw-bold">Titulo:</div>
							<div class="col" id="oTitulo"></div>
						</div>
						<div class="row align-items-center mb-1">
							<div class="col-3 fw-bold">Codigo:</div>
							<div class="col" id="oCodigo"></div>
							<div class="col-2 col-lg-1 fw-bold">Fecha:</div>
							<div class="col" id="oFecha"></div>
						</div>
						<div class="row align-items-center mb-1">
							<div class="col-3 fw-bold">Cliente:</div>
							<div class="col" id="oCliente"></div>
							<div class="w-100 d-block d-lg-none"></div>
							<div class="col-3 col-lg-1 fw-bold">Correo:</div>
							<div class="col" id="oCorreo"></div>
						</div>
						<div class="row align-items-center mb-1">
							<div class="col-3 fw-bold">Estado:</div>
							<div class="col" id="oEstado"></div>
						</div>
						<div class="row align-items-center mb-1">
							<div class="col-3 fw-bold">Tema:</div>
							<div class="col" id="oTema"></div>
						</div>
						<div class="row align-items-center mb-1">
							<div class="col-3 fw-bold">Departamento:</div>
							<div class="col" id="oDepartamento"> aaaa</div>
						</div>
						<div class="row align-items-center mb-1">
							<div class="col-3 fw-bold">Fuente:</div>
							<div class="col" id="oFuente"></div>
						</div>
						<div class="fw-bold mt-4">Descripcion del problema:</div>
						<textarea id="oProblema" class="boxsizingBorder" readonly></textarea>
						<div id="modalOpt"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<script>
			function err(message)
			{
				document.getElementById("errorO").innerHTML = `<p class="text-danger m-2">${message}</p>`;
			}

			function consultar()
			{	
				correo = document.getElementById("correoI").value;
				
				if(correo === "")
				{
					err("El campo de correo no debe estar vacío.");
					return;
				}
				else if (!document.getElementById("correoI").checkValidity())
				{
					err("El correo es invalido.");
					return;
				}
				window.location.href = '/consultar.php?mail='+correo;
			}

			function detalles(codigo)
			{
				var obj = {codigo: codigo};

				var xhr = new XMLHttpRequest();
				xhr.open("POST", "/api/detalles.php", true);
				xhr.onload = function (e) {
					if (xhr.readyState === 4) {
						if (xhr.status === 200) {
							var response = JSON.parse(xhr.response);
							console.log(response);
							document.getElementById("oTitulo").innerHTML = response.titulo;
							document.getElementById("oFuente").innerHTML = response.fuente;
							document.getElementById("oDepartamento").innerHTML = response.departamento;
							document.getElementById("oTema").innerHTML = response.tipo;
							document.getElementById("oEstado").innerHTML = response.estado;
							document.getElementById("oFecha").innerHTML = response.fecha;
							document.getElementById("oCodigo").innerHTML = response.codigo;
							document.getElementById("oProblema").innerHTML = response.problema;
							document.getElementById("oCliente").innerHTML = response.nombre;
							document.getElementById("oCorreo").innerHTML = response.correo;
							document.getElementById("oProblema").innerHTML = response.desc_problema;
							if(response.tecnico !== null && response.correo_tecnico !== null)
							{
								if(response.telefono_tecnico === null)
									response.telefono_tecnico = "-";
								
								document.getElementById("modalOpt").innerHTML = `
								<div class="row align-items-center mb-1">
									<div class="col-3 fw-bold">Técnico:</div>
									<div class="col">${response.tecnico}</div>
									<div class="w-100 d-block d-lg-none"></div>
									<div class="col-3 col-lg-1 fw-bold">Correo:</div>
									<div class="col">${response.correo_tecnico}</div>
								</div>
								<div class="row align-items-center mb-1">
									<div class="col-3 fw-bold">Telefono:</div>
									<div class="col">${response.telefono_tecnico}</div>
								</div>
								<div class="fw-bold mt-4">Respuesta del técnico:</div>
								<textarea class="boxsizingBorder" readonly>${response.resolucion_problema}</textarea>
								`;
							}
							else
								document.getElementById("modalOpt").innerHTML = "";
							
							var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
							myModal.toggle();

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
		<!-- Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
	</body>
</html>

