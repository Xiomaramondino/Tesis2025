<!-- app/Views/horarios_add.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Horario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <style>
    * { 
      margin: 0;
      padding: 0;
      box-sizing: border-box; /* Asegura que los márgenes y rellenos no afecten el tamaño total de los elementos */
    }
    body {
      height: 100vh;
      width: 100%;
      display: flex;
      justify-content: flex-start; /* Alinea el contenido hacia la parte superior */
      align-items: flex-start;
      background-color: #b6a0d7;
      overflow-x: hidden; /* Evita el desplazamiento horizontal */
      padding-bottom: 80px; /* Agrega espacio para que no se sobreponga el footer */
    }
    .card {
      background-color: #ebdef0;
      width: 35rem; /* Se asegura de que el tamaño de la card sea fijo */
      height: auto; /* Ajusta la altura según el contenido */
      margin-top: 150px; /* Separar la card de la navbar */
      margin-left: 400px;
    }
    .card-body{
      margin-top: -60px;
    }
    .navbar {
      width: 100%; /* La barra de navegación ocupa el 100% del ancho */
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #540466;
      padding: 1rem 2rem;
      position: fixed; /* Mantiene la navbar fija en la parte superior */
      top: 0;
      left: 0;
      z-index: 9999; /* Asegura que la navbar esté por encima de otros elementos */
    }
    .navbar .logo {
      color: white;
      font-size: 1.8rem;
      font-weight: bold;
      display: flex;
    }
    .navbar-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

/* Estilo común para el botón "Volver" plano */
.volver-btn {
    background-color: transparent;
    color: white;
    border: none;
    padding: 0.3rem 0.8rem;
    font-size: 1rem;
    text-align: left;
    cursor: pointer;
    text-decoration: none;
}

/* Sin efectos visuales */
.volver-btn:hover,
.volver-btn:active,
.volver-btn:focus {
    background-color: transparent;
    color: white; 
    outline: none;
}
  
    .container {
      padding-top: 80px; /* Para evitar que el contenido quede cubierto por la navbar fija */
    }
    .footer {
      position: absolute; /* Esto asegura que el footer se quede al final */
      bottom: 0;
      width: 100%; /* Hace que el footer ocupe todo el ancho */
      text-align: center;
      padding: 1rem;
      background-color: #4a045a;
      font-weight: bold;
      color: white;
    }
    .alert {
      margin-bottom: 1rem; 
    }
  </style>
  

  <nav class="navbar sticky-top">
<img src="http://localhost/juanxiomaram2024/tesina2025/fondo/DINGDONG.jpg" width="60px" alt="Logo">
    <div class="logo" style="padding-right: -600px;">DING DONG PRO</div>

    <div class="navbar-buttons">
        <form action="<?= base_url('/horarios'); ?>" method="get">
            
            <button type="submit" class="btn btn-sm volver-btn">Volver</button>
        </form>
    </div>
</nav>
  
  
   <div class="card">
     <div class="card-body">
       <div class="container text-center">
       <?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger" role="alert">
    <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>

         <div class="row justify-content-md-center">
           <div class="col-md-8">
             <h3><em>𝓐𝓰𝓻𝓮𝓰𝓪𝓻 𝓱𝓸𝓻𝓪𝓻𝓲𝓸𝓼</em></h3>
             <form action="<?= base_url('horarios/add') ?>" method="post">
               <label for="evento">Evento:</label>
               <input type="text" name="evento" class="form-control" required>
               <label for="hora">Hora:</label>
               <input type="time" name="hora" class="form-control" required>
               <br>
               <input class="btn btn-sm" style="background-color: #540466; color:white;" type="submit" value="Agregar">
             </form>
           </div>
         </div>
       </div>
     </div>
   </div>
   
   <footer class="footer">
      <p>Tesis timbre automático 2025 <br>
          Marquez Juan - Mondino Xiomara
      </p>
   </footer>

</body>
</html>
