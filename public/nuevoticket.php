<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="/styles/style.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

		<title>Panel de administración</title>
	</head>
	<body>
		<div class="container">
			<h2>Tele-Ticket</h2>
			<div class="row justify-content-end">
				<div class="col-auto">
					<a class="btn btn-primary" href="/index.php">Salir</a>
				</div>
			</div>
			<ul class="nav mb-4">
				<li class="nav-item">
					<a class="nav-link active" href="/admin.php">Tickets</a>
				</li>
				<li class="nav-item">
					<p class="nav-link disabled">Nuevo ticket</p>
				</li>
			</ul>

			<div class="container bg-light mb-4 p-2">
				<div class="row mb-4">
					<div class="col-2 " >
						<a href="/admin.php" >Nuevos</a>
					</div>
					<div class="col-2">
						<a href="/admin.php?tipo=1">Asignados</a>
					</div>
					<div class="col-2">
						<a href="/admin.php?tipo=2">Resueltos</a>
					</div>
				</div>
				<div id="alertLoc">
				</div>
				<form>
					<p class="text-white bg-primary p-1">Usuario</p>
					<div class="container pb-3">
						<div class="mb-1">
							<div class="row justify-space-evenly">
								<div class="col">
									<label class="form-label">Nombre: <p id="nombreI">Seleccione un usuario</p></label>
								</div>
								<div class="col">
									<button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Cambiar usuario</button>
								</div>
							</div>
						</div>
						<div class="mb-2">
							<label class="form-label">Correo: <p id="correoI"></p></label>
						</div>
						<div class="mb-2 form-check">
							<input type="checkbox" class="form-check-input" id="exampleCheck1">
							<label class="form-check-label" for="exampleCheck1">Aviso ticket</label> <!-- Sin input -->
						</div>
					</div>
					<p class="text-white bg-primary p-1">Ticket</p>
					<div class="container pb-3">
						<div class="row justify-space-evenly">
							<div class ="col">
								<div class="mb-2">
									<label for="tituloI" class="form-label">Título</label>
									<input type="text" class="form-control" id="tituloI">
								</div>
							</div>
							<div class ="col">
								<div class="mb-2">
									<label for="estadoI" class="form-label">Estado inicial</label>
									<select class="form-select" id="estadoI" aria-label="Select">
										<option value="0" selected>Abierto</option>
										<option value="1">Asignado / Cerrado</option>
										<option value="2">Resuelto</option>
									</select>
								</div>
							</div>
						</div>
						<div class="mb-2">
							<label for="fuenteI" class="form-label">Fuente</label>
							<select class="form-select" id="fuenteI" aria-label="Select">
								<option value="0" selected>Telefono</option>
								<option value="1">Correo</option>
								<option value="2">Chat</option>
								<option value="3">Formulario</option>
							</select>
						</div>
						<div class="mb-2">
							<label for="temaI" class="form-label">Tema asociado</label>
							<input class="form-control" type="text" name="city" list="temalist" id="temaI">
							<datalist id="temalist">
								<option value="Problemas de hardware">
								<option value="Problemas de conexión">
								<option value="Problemas de acceso">
								<option value="Error de software">
							</datalist>
						</div>
						<div class="mb-2">
							<label for="departamentoI" class="form-label">Departamento</label>
							<select class="form-select" id="departamentoI" aria-label="Select">
								<option value="0" selected>Soporte</option>
								<option value="1">Redes</option>
								<option value="2">Servidores</option>
							</select>
						</div>
						<div class="mb-2">
							<label for="fechaI" class="form-label">Fecha de expiración</label>
							<input type="date" min="1899-01-01" class="form-control" id="fechaI">
						</div>
						<div class="mb-2">
							<label for="problemaI" class="form-label">Descripcion del problema</label>
							<textarea class="form-control" id="problemaI" row=3></textarea>
						</div>
						<div class="mb-2">
							<label for="respuestaI" class="form-label">Respuesta inicial</label>
							<select class="form-select form-select-sm mb-1" aria-label="Select" onchange="FillResponse(this)">
								<option value="0" selected></option>
								<option value="1">Respuesta de espera</option>
							</select>
							<textarea class="form-control" id="respuestaI" row=3></textarea>
						</div>
					</div>
					<p class="text-danger" id="errorO"></p>
					<button type="button" class="btn btn-primary" onClick="sendFun()">Abrir ticket</button>
				</form>

			
		</div>
		

		<script>
		var usrList = [
			<?php
				$dbh = new PDO('mysql:host=localhost;dbname=teleticket', "root", "");
				$stmt = $dbh->prepare("SELECT * from Usuarios");
				$stmt->execute();
				foreach($stmt as $row)
				{
					echo '{ Nombre: "'. $row['Nombre'] . '", Correo: "'. $row['Correo'] .'" },';
				}
			?>
		];
		</script>

		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Cambiar usuario</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">

					<form class="mb-5">
						<p class="lead">Agregar usuario</p>
						<div class="mb-3">
							<label for="nombreIMf" class="form-label">Nombre</label>
							<input type="text" class="form-control" id="nombreIMf">
						</div>
						<div class="mb-3">
							<label for="correoIMf" class="form-label">Correo</label>
							<input type="email" class="form-control" id="correoIMf">
						</div>
						<button type="button" class="btn btn-primary" onClick="addUser()" data-bs-dismiss="modal">Agregar</button>
					</form>

					<p class="lead">Buscar existente</p>
					<ul class="list-group" id="listaModal">
						
					</ul>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary" data-bs-dismiss="modal" onClick="selUser()">Seleccionar</button>
					</div>
				</div>
			</div>
		</div>

		<script>
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			if(dd<10){
				dd='0'+dd
			} 
			if(mm<10){
				mm='0'+mm
			} 

			today = yyyy+'-'+mm+'-'+dd;
			document.getElementById("fechaI").setAttribute("min", today);

			function FillResponse(val)
			{
				val = val.value; 
				if(val == 0)
					document.getElementById("respuestaI").value = "";
				else if(val == 1)
				{
					document.getElementById("respuestaI").value =
					"Por favor, espere mientras nuestros técnicos resuelven el problema. Lo mantendremos al tanto.";
				}
			}

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
					fecha:     document.getElementById("fechaI").value
				};

				if(obj.correo === "")
				{
					document.getElementById("errorO").innerHTML = "Seleccione un usuario primero.";
					return;
				}
				else
					document.getElementById("errorO").innerHTML = "";
				
				if(obj.fecha === "")
				{
					obj.fecha = null;
				}

				var xhr = new XMLHttpRequest();
				xhr.open("POST", "/ticketAsync.php", true);
				xhr.onload = function (e) {
					if (xhr.readyState === 4) {
						if (xhr.status === 200) {
							console.log(xhr.response);
						} else {
							console.error(xhr.statusText);
						}
					}
				};
				xhr.onerror = function (e) {
					console.error(xhr.statusText);
				};
				xhr.send(JSON.stringify(obj));

				document.getElementById("alertLoc").innerHTML =`
				<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
					<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
					Ticket creado exitosamente.
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>`;

				document.getElementById("nombreI").innerHTML = "";
				document.getElementById("correoI").innerHTML = "";
				document.getElementById("tituloI").value = "";
				document.getElementById("estadoI").value = 0;
				document.getElementById("fuenteI").value = 0;
				document.getElementById("temaI").value = "";
				document.getElementById("departamentoI").value = 0;
				document.getElementById("respuestaI").value = "";
				document.getElementById("problemaI").value = "";
				document.getElementById("fechaI").value = "";
			}

			var active = -1;
			function selFun(index)
			{
				active = index;
				c = document.getElementById("listaModal").children; 
				var i
				for(i = 0; i < c.length; i++)
				{
					let node = c[i];
					if(i == index)
					{
						node.setAttribute("class", "list-group-item list-group-item-action active");
						node.setAttribute("aria-current", "true");
					}
					else
					{
						node.setAttribute("class", "list-group-item list-group-item-action");
						node.removeAttribute("aria-current");
					}
				}
			}

			function addUser(index)
			{
				var obj = {
					Nombre: document.getElementById("nombreIMf").value,
					Correo: document.getElementById("correoIMf").value,
					Telefono: null
				}

				var xhr = new XMLHttpRequest();
				xhr.open("POST", "/addUserAsync.php", true);
				xhr.onload = function (e) {
					if (xhr.readyState === 4) {
						if (xhr.status === 200) {
							var code = parseInt(xhr.response);
							if(code == 0)
							{
								usrList.push(obj);
								document.getElementById("nombreI").innerHTML = obj.Nombre;
								document.getElementById("correoI").innerHTML = obj.Correo;

								var node = document.createElement("LI");
								node.setAttribute("class", "list-group-item list-group-item-action"); 
								node.setAttribute("onClick", "selFun("+(usrList.length-1)+")"); 
								var textnode = document.createTextNode(obj.Nombre);
								node.appendChild(textnode);
								document.getElementById("listaModal").appendChild(node);
							}
							else
								alert('Este correo ya existe en el sistema.');
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

			function selUser()
			{
				if(active >= 0)
				{
					document.getElementById("nombreI").innerHTML = usrList[active].Nombre;
					document.getElementById("correoI").innerHTML = usrList[active].Correo;
				}
			}

			var i
			for(i = 0; i < usrList.length; i++)
			{
				var node = document.createElement("LI");
				node.setAttribute("class", "list-group-item list-group-item-action"); 
				node.setAttribute("onClick", "selFun("+i+")"); 
				var textnode = document.createTextNode(usrList[i].Nombre);
				node.appendChild(textnode);
				document.getElementById("listaModal").appendChild(node); 
			}
			
		</script>
		<br><br><br>
		<!-- Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
	</body>
</html>
