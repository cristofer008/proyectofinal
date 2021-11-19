<?php

$tipoTicket = 0;
$keywords = null;
$departamento = null;
$start = null; $end = null;
$cliente = null;
$tecnico = null;

$extra = "";

if (!empty($_GET))
{
	if(isset($_GET['tipo'])){
		$tipoTicket = $_GET['tipo'];
		if($tipoTicket >= 0)
			$extra .= " estado = ? ";
		else if ($tipoTicket == -1)
			$extra .= " 1=1 ";
		else
		{
			$extra .= " fecha_exp < CURDATE() AND estado <> 2 ";
		}
	}

	if(isset($_GET['keywords'])){
		$keywords = $_GET['keywords'];
		$extra .= " AND (titulo LIKE ? OR desc_problema LIKE ? OR codigo LIKE ?)";
	}

	if(isset($_GET['departamento'])){
		$departamento = $_GET['departamento'];
		$extra .= " AND (tickets.departamento = ?)";
	}

	if(isset($_GET['start']) && isset($_GET['end']))
	{
		$start = $_GET['start'];
		$end = $_GET['end'];
		$extra .= " AND (fecha BETWEEN ? AND ?)";
	}

	if(isset($_GET['cliente'])){
		$cliente = $_GET['cliente'];
		$extra .= " AND (usuarios.Nombre LIKE ? OR usuarios.Correo LIKE ?)";
	}

	if(isset($_GET['tecnico'])){
		$tecnico = $_GET['tecnico'];
		$extra .= " AND (tecnicos.nombre LIKE ? OR tecnicos.email LIKE ?)";
	}
}
?>	

<!doctype html>
<html lang="en" class="border border-primary" style="width:100%;overflow-x:hidden">
   
	<head>
	     
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="/styles/admin.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

		<title>Panel de administración</title>
	</head>
	<body class="border border-danger" style="overflow:hidden; width: 98.65%">
	    <script>
		    if (document.documentElement.scrollHeight > window.screen.height) {
				
				alert("hola");
			}

		</script>
		<div class="container" style="overflow-x: hidden">
			<h2 class="text-center">Teleticket</h2>

			<div class="row justify-content-end">
				<form action="{{ route('logout') }}" method="post">
				@csrf
				<div class="col-auto">
				    <a class="btn btn-primary" href="{{ route('logout') }}">  Salir</a>
				</div>
				</form>
			</div>
			<ul class="nav mb-4">
				<li class="nav-item">
					<p class="nav-link" href="/solicitudes.php">Solicitudes</p>
				</li>
				<li class="nav-item">
					<p class="nav-link" href="/tickets.php">Tickets</p>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/nuevoticket.php">Nuevo ticket</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/registrousuarios.php">Usuarios</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/nuevoticket.php">Conversaciones</a>
				</li>
			</ul>

			<div class="container bg-light mb-4 px-0 mx-auto">
				<div class="row mx-auto mb-4 px-0">
					<?php
						$secciones = array("Nuevos", "Abiertos", "Espera", "Resueltos", "Todos");
						$vals = array(0, 1, 2, 3, 4);
						echo '<div class="row px-0 mx-auto" style="background-color:white;">';
						for($i = 0; $i < count($secciones); $i++)
						{
							echo '<div class="col px-0 text-center mx-auto" style="padding:0px 0px">';
							if($vals[$i] == $tipoTicket)
								echo $secciones[$i];
							else
								echo '<a href="/admin.php?tipo='.$vals[$i].'" style="padding:0px 0px;">'. $secciones[$i] .'</a>';
							echo '</div>';
						}
						echo '</div>'
					?>
				</div>
			
				<div class="input-group">
					<div class="form-outline d-flex mx-auto">
						<input type="search" id="directSearch" class="form-control" onChange="search1()" style="margin:auto; border-radius: 2% 0% 0% 2%"/>
						<button type="button" class="d-inline btn btn-primary" onClick="search1()" style="margin:auto; border-radius: 0% 5% 5% 0%">
							Buscar
						</button>
					</div>
					<div>
					<?php 
						echo '<a style="position:absolute; right: 5%; top: 15%;" class="fw-light" href="/admin.php?tipo='. $tipoTicket . '">[Limpiar busqueda]</a>'
					?>
					<a style="position:absolute; right: 20%; top:15%; cursor: pointer;" class="fw-light" data-bs-toggle="modal" data-bs-target="#searchModal">[Búsqueda avanzada]</a>
					</div>
		        </div>	
				<?php
					$dbh = new PDO('mysql:host=localhost;dbname=teleticket', "root", "");
					$stmt = $dbh->prepare("SELECT *, usuarios.nombre AS cliente, tecnicos.nombre AS tecnico, tecnicos.email AS correo_tecnico from tickets
					inner join usuarios on id_solicitante = usuarios.Id 
					LEFT JOIN tecnicos ON tecnicos.id_tecnico = tickets.id_tecnico WHERE ".$extra);
					$paramI = 1;
					if($tipoTicket >= 0)
					{
						$stmt->bindParam(1, $tipoTicket);
						$paramI += 1;
					}
					if(!is_null($keywords))
					{
						$keywords = "%".$keywords."%";
						$stmt->bindParam($paramI, $keywords);
						$stmt->bindParam($paramI+1, $keywords);
						$stmt->bindParam($paramI+2, $keywords);
						$paramI += 3;
					}
					if(!is_null($departamento))
					{
						$stmt->bindParam($paramI, $departamento);
						$paramI += 1;
					}
					if(!is_null($start) && !is_null($end))
					{
						$stmt->bindParam($paramI, $start);
						$stmt->bindParam($paramI+1, $end);
						$paramI += 2;
					}
					if(!is_null($cliente))
					{
						$cliente = "%".$cliente."%";
						$stmt->bindParam($paramI, $cliente);
						$stmt->bindParam($paramI+1, $cliente);
						$paramI += 2;
					}
					if(!is_null($tecnico))
					{
						$tecnico = "%".$tecnico."%";
						$stmt->bindParam($paramI, $tecnico);
						$stmt->bindParam($paramI+1, $tecnico);
						$paramI += 2;
					}
					$stmt->execute();
					if($stmt->rowCount() > 0)
					{
						?>
						<table class="table table-striped mt-4">
							<thead>
								<tr>
									<th scope="col" style="text-align:center; overflow:hidden;"></th>
									<th scope="col" style="text-align:center; overflow:hidden;">Título</th>
									<th scope="col" style="text-align:center; overflow:hidden;">Fecha de creación</th>
									<th scope="col" style="text-align:center; overflow:hidden;">Fecha de expiración</th>
									<th scope="col" style="text-align:center; overflow:hidden;">Solicitante</th>
									<th scope="col" style="text-align:center; overflow:hidden;">Encargado</th>
									<th scope="col" style="text-align:center; overflow:hidden;">Detalles</th>
								</tr>
							</thead>
							<tbody id="resultsTable">
							<?php
								foreach($stmt as $row)
								{
									echo '<tr style="margin:auto">';
									echo '<td style="text-align:center; overflow:hidden;"><input type="checkbox" data-codigo="'.$row['codigo'].'" onchange="chkCount(this)"></td>';
									echo '<td style="text-align:center; overflow:hidden;">'. $row['titulo'] .'</td>';
									echo '<td style="text-align:center; overflow:hidden;">'. $row['fecha'] .'</td>';
									if(!is_null($row['fecha_exp']))
										echo '<td overflow:hidden;>'. $row['fecha_exp'] .'</td>';
									else
										echo '<td style="text-align:center; overflow:hidden;">-</td>';
										echo '<td style="text-align:center; overflow:hidden;">' . $row['cliente'] . '</td>';
									if(!is_null($row['tecnico']))
										echo '<td style="text-align:center; overflow:hidden;">' . $row['tecnico'] . '</td>';
									else
										echo '<td style="text-align:center; overflow:hidden;"><a class="text-decoration-none cursorClickIcon" onClick="asignar('.$row['codigo'].')">[Asignar]</a></td>';
										echo '<td style="text-align:center; overflow:hidden;"> <a class="text-decoration-none cursorClickIcon" onClick="detalles('.$row['codigo'].')">[Ver detalles]</a></td>';
										echo '</tr>';
								}
							?>
								
							</tbody>
						</table>
						
						<button type="button" class="btn btn-danger" id="eliminarBtn" disabled onClick="eliminarDialog()">Eliminar</button>
						
						
						<?php
							}
							else
							{
								echo '<p class="fs-4 mt-4 text-center">No hay tickets</p>';
							}
						?>
			</div>
		</div>

		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header text-center">
						<h5 class="modal-title" id="exampleModalLabel">Detalles del ticket</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="row align-items-center mb-1">
							<div class="col-3 fw-bold">Titulo:</div>
							<div class="col" id="oTitulo"></div>
						</div>
						<div class="row align-items-center mb-1">
							<div class="col-2 col-lg-1 fw-bold">Codigo:</div>
							<div class="col-1" id="oCodigo"></div>
							<div class="col-2 col-lg-1 fw-bold">Fecha:</div>
							<div class="col" id="oFecha"></div>
							<div class="col-2 col-lg-1 fw-bold">Expira:</div>
							<div class="col" id="oFecha2"></div>
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
						<button type="button" class="btn btn-primary" data-bs-dismiss="modal" onClick="editar()">Editar</button>

						<?php 
							if($tipoTicket == 3)
								echo '<button type="button" class="btn btn-primary" data-bs-dismiss="modal" onClick="aceptarResolucion()">Aceptar resolución</button>'
						?>
						
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="warnModal" tabindex="-1" aria-labelledby="warnModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
				
					<div class="modal-header">
						<h5 class="modal-title" id="warnModalLabel">Eliminar tickets</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					
					<div class="modal-body">
						<p id="modalWarnMsg"></p>
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onClick="eliminar()">Eliminar</button>
					</div>
					
				</div>
			</div>
		</div>


       <!-- MODAL DE BÚSQUEDA AVANZADA --------------------------------------------------------------------------------------------------------------- -->
		<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="searchModalLabel">Búsqueda avanzada</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-2">
							<label for="smKeywords" class="form-label">Codigo, título o descripción</label>
							<input type="search" class="form-control form-control-sm" id="smKeywords"/>
						</div>
						<div class="mb-2">
							<label for="smEstado" class="form-label">Buscar en estado del ticket</label>
							<select class="form-select form-select-sm" id="smEstado" aria-label="Select">
								<option value="-1">Cualquiera</option>
								<option value="0">Nuevo</option>
								<option value="1">Abierto</option>
								<option value="2">Espera</option>
								<option value="3">Resuelto</option>
							</select>
						</div>
						<div class="mb-2">
							<label for="smDepartamento" class="form-label">Buscar en departamento</label>
							<select class="form-select form-select-sm" id="smDepartamento" aria-label="Select">
								<option value="-1" selected>Cualquiera</option>
								<option value="0">Soporte</option>
								<option value="1">Redes</option>
								<option value="2">Servidores</option>
							</select>
						</div>
						<div class="mb-2">
							<label for="smCliente" class="form-label">Buscar por cliente</label>
							<input type="text" class="form-control form-control-sm" id="smCliente">
						</div>
						<div class="mb-2">
							<label for="smTecnico" class="form-label">Buscar por técnico</label>
							<input type="text" class="form-control form-control-sm" id="smTecnico">
						</div>
						<div class="mb-2">
							<label for="smStart" class="form-label">Fecha de inicio</label>
							<input type="date" class="form-control form-control-sm" id="smStart">
						</div>
						<div class="mb-2">
							<label for="smEnd" class="form-label">Fecha de término</label>
							<input type="date" class="form-control form-control-sm" id="smEnd">
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary" data-bs-dismiss="modal" onClick="search2()">Buscar</button>
					</div>
				</div>
			</div>
		</div>
        <!-- FIN BÚSQUEDA AVANZADA *************************************************************************************************************************-->
		
		<!-- MODAL ASIGNAR TÉCNICO ------------------------------------------------------------------------------------------------------------------------ -->
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
					</div>
				</div>
			</div>
		</div>
        <!-- FIN MODAL ASIGNAR TÉCNICO ***************************************************************************************************************************** -->

		<script>
			var editCode = -1;
			var tipoTicket = <?php echo $tipoTicket ?>;
			var codigos = [];
			var codigoTecnico = null;
			var checkboxCount = 0;
			var checkList = document.getElementById("resultsTable")
			if(checkList !== null)
			{
				checkList=checkList.getElementsByTagName("input");
				for (var i=0; i<checkList.length; i++)
				{
					checkboxCount += checkList[i].checked;
				}
			}
			
			function logout(){
			
				xhttp.open("POST", "/logout", false);           //{{ route('logout') }}
				xhttp.setRequestHeader('X-CSRF-TOKEN', csrf_token); 
				xhttp.send();
			}

			function aceptarResolucion()
			{
				var obj = {
					codigo: editCode
				};

				var xhr = new XMLHttpRequest();
				xhr.open("POST", "/api/ticketUpdate.php?type=2", true);
				xhr.onload = function (e) {
					if (xhr.readyState === 4) {
						if (xhr.status === 200) {
							console.log(xhr.response);
							location.reload(true);
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

			function editar(codigo)
			{
				let request = "editarTicket.php?mode=0&codigo="+editCode;
				request+= "&b="+btoa(window.location.href);
				window.location.href = request;
			}


            /* ---------------- FUNCION PARA OBTENER EL LISTADO DE TÉCNICOS ------------------------------------------------------------------------------------ */ 
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
								node.setAttribute("onClick", "asignarTecnico("+codigoTecnico+","+response[i].id_tecnico+")");
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
			/* FIN FUNCION TECNICOS ******************************************************************************************************************************* */
			
			
			/* ASIGNAR TECNICO -------------------------------------------------------------------------------------------------------------------------------------*/ 
			function asignarTecnico(codigo, tecnico)
			{
				let obj = {
					tecnico: tecnico,
					codigo: codigo
				};

				let xhr = new XMLHttpRequest();
				xhr.open("POST", "/api/asignar.php", true);
				xhr.onload = function (e) {
					if (xhr.readyState === 4) {
						if (xhr.status === 200) {
							console.log(xhr.response);
							location.reload(true);
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
			/* FIN FUNCION ASIGNAR TÉCNICO ******************************************************************************************************************************/ 

			/* */
			function asignar(codigo) //Dialogo modal
			{
				codigoTecnico = codigo;
				getTecnicos("");
				document.getElementById('tecnicoSearch').value = "";
				var myModal = new bootstrap.Modal(document.getElementById('asignarModal'));
				myModal.toggle();
			}

			function search2()
			{
				let keywords = document.getElementById("smKeywords").value;
				let estado = document.getElementById("smEstado").value;
				let depto = document.getElementById("smDepartamento").value;
				let cliente = document.getElementById("smCliente").value;
				let tecnico = document.getElementById("smTecnico").value;
				let start = document.getElementById("smStart").value;
				let end = document.getElementById("smEnd").value;

				console.log(start);
				console.log(end);

				let request = "/admin.php?tipo="+estado;
				if(keywords !== "")
					request += "&keywords="+keywords;
				if(depto >= 0)
					request += "&departamento="+depto;
				if(cliente !== "")
					request += "&cliente="+cliente;
				if(tecnico !== "")
					request += "&tecnico="+tecnico;

				if(start !== "" || end !== "")
				{
					if(start === "")
						request+= "&start=1960-01-01";
					else
						request+= "&start="+start;
					if(end === "")
						request+= "&end=2100-01-01";
					else
						request+= "&end="+end;
				}

				window.location.href = request;
			}

			function search1()
			{
				let request = "/admin.php?tipo="+tipoTicket;
				request += "&keywords="+document.getElementById("directSearch").value;

				window.location.href = request;
			}
			
			/* FUNCION ELIMINAR TICKETS -------------------------------------------------------------------------------------------------------------------*/
			function eliminarDialog()
			{
				codigos = [];
				for (var i=0; i<checkList.length; i++)
				{
					if(checkList[i].checked)
					{
						codigos.push(checkList[i].getAttribute("data-codigo"));
					}
				}
				
				document.getElementById("modalWarnMsg").innerHTML =
				"Está a punto de eliminar "+ codigos.length +" ticket(s). ¿Confirma esta acción?";

				var myModal = new bootstrap.Modal(document.getElementById('warnModal'));
				myModal.toggle();
			}
			/* FIN FUNCION ELIMINAR TICKETS **********************************************************************************************************************/

			function eliminar()
			{
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "/api/eliminarTickets.php", true);
				xhr.onload = function (e) {
					if (xhr.readyState === 4) {
						if (xhr.status === 200) {
							console.log(xhr.response);
							location.reload(true);
						} else {
							console.error(xhr.statusText);
						}
					}
				};
				xhr.onerror = function (e) {
					console.error(xhr.statusText);
				};
				xhr.send(JSON.stringify(codigos));
			}

			function chkCount(checkbox)
			{
				var btn = document.getElementById("eliminarBtn");
				if(checkbox.checked)
					checkboxCount++;
				else
					checkboxCount--;

				if(checkboxCount > 0)
					btn.removeAttribute("disabled");
				else
					btn.setAttribute("disabled", "");
			}


			function detalles(codigo)
			{
				editCode = codigo;
				var obj = {codigo: codigo};

				var xhr = new XMLHttpRequest();
				xhr.open("POST", "/api/detalles.php", true);
				xhr.onload = function (e) {
					if (xhr.readyState === 4) {
						if (xhr.status === 200) {
							var response = JSON.parse(xhr.response);
							if(response === false)
								window.location.reload(true); 
							console.log(response);
							document.getElementById("oTitulo").innerHTML = response.titulo;
							document.getElementById("oFuente").innerHTML = response.fuente;
							document.getElementById("oDepartamento").innerHTML = response.departamento;
							document.getElementById("oTema").innerHTML = response.tipo;
							document.getElementById("oEstado").innerHTML = response.estado;
							document.getElementById("oFecha").innerHTML = response.fecha;
							document.getElementById("oFecha2").innerHTML = response.fecha_exp;
							document.getElementById("oCodigo").innerHTML = response.codigo;
							document.getElementById("oProblema").innerHTML = response.problema;
							document.getElementById("oCliente").innerHTML = response.nombre;
							document.getElementById("oCorreo").innerHTML = response.correo;
							document.getElementById("oProblema").innerHTML = response.desc_problema;
							if(response.tecnico !== null && response.correo_tecnico !== null)
							{
								document.getElementById("modalOpt").innerHTML = `
									<div class="row align-items-center mb-1">
										<div class="col-3 fw-bold">Técnico:</div>
										<div class="col">${response.tecnico}</div>
										<div class="w-100 d-block d-lg-none"></div>
										<div class="col-3 col-lg-1 fw-bold">Correo:</div>
										<div class="col">${response.correo_tecnico}</div>
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
