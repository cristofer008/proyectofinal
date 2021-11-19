<!doctype html>
<html>

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link href="/styles/admin.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

	<title> Panel registro usuario </title>

</head>

<body>
    <header>
		<h2 class="text-center">Teleticket</h2>
	</header>
	
	<section class="container border w-100 px-0 py-0 mx-auto my-auto" style="">
	    <div class="row border w-100 px-0 py-0 mx-auto">
		Para agregar a un nuevo usuario complete el siguiente formulario
		</div>
		<div class="row  w-100 mx-auto">
		
			<div class="mb-3 row d-flex flex-row justify-content-center mx-auto w-100">
				<label for="exampleInputEmail1" class="form-label text-center">Nombres:</label>
				
				<div class="col justify-content-center py-0 my-0 ">
					<input type="email" class="form-control mx-auto col-10" id="exampleInputEmail1" aria-describedby="emailHelp">
		            <div id="emailHelp" class="form-text text-center" style="mx-auto py-0 my-0">Primer nombre.</div>
				</div>
				<div class="col-1 ">
				
				</div>
				<div class="col justify-content-center  py-0 my-0">
					<input type="email" class="form-control mx-auto col-10" id="exampleInputEmail1" aria-describedby="emailHelp">
					<div id="emailHelp" class="form-text text-center" style="mx-auto py-0 my-0">Segundo nombre (opcional).</div>
				</div>
				
			 </div>
			 
			 
			 <div class="mb-3 row d-flex flex-row justify-content-center mx-auto gx-4 py-0 my-0 w-100">
				<label for="exampleInputEmail1" class="form-label text-center">Apellidos:</label>
				<div class="col">
					<input type="email" class="form-control col-10 mx-auto" id="exampleInputEmail1" aria-describedby="emailHelp">
					<div id="emailHelp" class="form-text text-center" style="mx-auto py-0 my-0">Apellido paterno.</div>
		        </div>
				<div class="col-1">
				</div>
				<div class="col">
					<input type="email" class="form-control col-10 mx-auto" id="exampleInputEmail1" aria-describedby="emailHelp">
					<div id="emailHelp" class="form-text text-center" style="mx-auto py-0 my-0">Apellido materno.</div>
				</div>
			 </div>
			
			
			<div class="mb-3 row mx-auto gx-4">
				<label for="exampleInputEmail1" class="form-label text-center">Correo electrónico:</label>
				<div class="col-8 mx-auto">
					<input type="email" class="form-control col" id="exampleInputEmail1" aria-describedby="emailHelp">
				</div>
				<div id="emailHelp" class="form-text text-center">Esta información permanecerá en privado.</div>
			 </div>
			 
			<div class="mb-3 row mx-auto gx-4">
				<label for="exampleInputEmail1" class="form-label text-center">Teléfono (opcional):</label>
				<div class="col-8 mx-auto">
					<input type="email" class="form-control col" id="exampleInputEmail1" aria-describedby="emailHelp">
				</div>
				<div id="emailHelp" class="form-text text-center">Este campo es opcional.</div>
			</div>
			
			<div class="mb-3 row d-flex flex-row justify-content-center mx-auto gx-4 py-0 my-0 w-100">
				<label for="exampleInputEmail1" class="form-label text-center">Rol:</label>
				<div class="col">
					<select class="col form-select" aria-label="Default select example">
					    <option selected>Seleccione rol</option>
					    <option value="1">Profesor</option>
						<option value="2">Inspector</option>
						<option value="3">Orientador</option>
						<option value="4">Administrativo</option>
						<option value="5">Secretaria</option>
					</select>
					<div id="emailHelp" class="form-text text-center" style="mx-auto py-0 my-0">Rol del usuario.</div>
		        </div>
				<div class="col-1">
				</div>
				<div class="col">
					<input type="email" class="form-control col-10 mx-auto" id="exampleInputEmail1" aria-describedby="emailHelp">
					<div id="emailHelp" class="form-text text-center" style="mx-auto py-0 my-0">Si es otro, especifíquelo.</div>
				</div>
			 </div>
			
			<div class="mb-3 row d-flex flex-row justify-content-center mx-auto gx-4 py-0 my-0 w-100">
			
				<label for="formFile" class="form-label text-center mx-auto px-0">Imagen de perfil:</label>
				
			    <div class="col-6">
					<div class="mx-auto col w-50 border self-align-center text-center" style="height: 15em; border-radius: 7%; border: ">
					    Fotografía
					</div>
				</div>
				
				<div class="col-6 align-items-center">
				
				    <input class="form-control col" type="file" id="formFile">
				</div>
				<div id="emailHelp" class="form-text text-center" style="mx-auto py-0 my-0">La imagen es opcional.</div>
			</div>
		    <hr>
		    <div class="mb-3 row text-center mx-auto">
			    <div class="col-5 d-block mx-auto" style=""> 
					<button type="button" class="btn btn-primary d-block mx-auto w-25">Enviar</button>
				</div>	
			</div>
		</div>
	</section>
	
    <footer>
    </footer>	

</body>

</html>
