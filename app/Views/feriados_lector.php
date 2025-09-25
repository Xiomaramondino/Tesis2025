<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feriados - Vista Lector</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<style>
 :root {
  --color-primary: #091342;
  --color-secondary: #081136;
  --color-tertiary: #070f2e;
  --color-danger: #e24363;
  --color-text-white: white;
  --color-text-light: #e0e0e0;
 }

 html, body {
  height: 100%;
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: var(--color-primary);
  color: var(--color-text-light);
 }

 body {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
 }

 /* --- Estilos de la Navbar Modificados --- */
 .navbar {
  width: 100%;
  background-color: var(--color-secondary);
  padding: 1rem 2rem;
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  justify-content: space-between; /* Alineación para 3 secciones */
  align-items: center;
  box-sizing: border-box;
  z-index: 1000;
 }

 .navbar-left img {
  height: 40px; /* Tamaño del logo ajustado */
 }

 .navbar-center {
  flex: 0 1 auto; /* Permite que el contenido determine el ancho, centrado */
 }

 .navbar-center .logo {
  color: var(--color-text-white);
  font-size: 1.9rem;
  font-weight: bold;
  text-align: center;
  display: flex;
  align-items: center;
  gap: 0.5rem; /* Espacio entre el icono y el texto */
 }

 .navbar-right {
  flex: 0 1 auto; /* Permite que el contenido determine el ancho */
 }

 .navbar-right .volver-btn {
  background: transparent;
  color: var(--color-text-white);
  font-size: 1rem;
  cursor: pointer;
  text-decoration: none;
  padding: 0.3rem 0.8rem; /* Añadido padding para mejor hit area */
  border: none;
  transition: color 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem; /* Espacio entre el icono y el texto */
 }

 .navbar-right .volver-btn:hover { color: #d4b8e0; }
 /* --- Fin de Estilos de la Navbar Modificados --- */

 main {
  flex: 1;
  padding: 100px 2rem 2rem 2rem;
  max-width: 950px;
  width: 100%;
  margin: 0 auto;
  box-sizing: border-box;
 }

 .card {
  background: var(--color-secondary);
  border-radius: 1.5rem;
  padding: 2rem;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
 }

 .card-title {
  text-align: center;
  font-weight: 700;
  margin-bottom: 1.5rem;
  color: #d4b8e0;
 }

 /* Tabla feriados */
 .tabla-feriados {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0 10px;
 }

 .tabla-feriados thead {
  background: var(--color-tertiary);
 }

 .tabla-feriados th {
  padding: 1rem;
  color: var(--color-text-white);
  text-align: center;
  font-size: 1rem;
  border-radius: 8px 8px 0 0;
 }

 .tabla-feriados tbody tr {
  background: rgba(255, 255, 255, 0.05);
  transition: transform 0.2s ease, background 0.2s ease;
 }

 .tabla-feriados tbody tr:hover {
  transform: scale(1.01);
  background: rgba(255, 255, 255, 0.1);
 }

 .tabla-feriados td {
  padding: 1rem;
  text-align: center;
  font-size: 1rem;
 }

 .tabla-feriados tr.feriado td .fecha {
  font-weight: bold;
  color: #80ed99; /* verde */
 }

 .tabla-feriados tr.excepcion td .fecha {
  font-weight: bold;
  color: #f87171; /* rojo */
 }

 .footer {
  text-align: center;
  background-color: var(--color-secondary);
  color: var(--color-text-white);
  font-weight: bold;
  padding: 0.8rem;
  margin-top: auto;
 }
</style>
</head>
<body>

<nav class="navbar">
 <div class="navbar-left">
  <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" alt="Logo">
 </div>
 <div class="navbar-center">
  <div class="logo">
   <i class=></i> RingMind
  </div>
 </div>
 <div class="navbar-right">
  <?php 
   $session = session();
   $rol = (int) $session->get('idrol');
  ?>
  <a href="<?php 
   if ($rol === 1) echo base_url('/admin/horarios');
   elseif ($rol === 3) echo base_url('/horarios_lector');
   elseif ($rol === 4) echo base_url('/profesor/horarios');
   else echo base_url('/');
  ?>" class="volver-btn">
   <i class="fas fa-arrow-left"></i> Volver
  </a>
 </div>
</nav>

<main role="main">
 <div class="card">

  <?php
   $session = session();
   $idcolegio = $session->get('idcolegio');
   $db = \Config\Database::connect();
   $dispositivo = $db->table('dispositivo')->where('idcolegio', $idcolegio)->get()->getRow();
  ?>

  <?php if ($dispositivo): ?>

      <h2 class="card-title">Excepciones del Colegio</h2>
   <?php if(!empty($excepciones)): ?>
    <table class="tabla-feriados">
     <thead>
      <tr>
       <th>Fecha</th>
       <th>Día</th>
       <th>Motivo</th>
      </tr>
     </thead>
     <tbody>
      <?php foreach($excepciones as $feriado): ?>
       <?php 
        $fechaObj = new DateTime($feriado['fecha']);
        $dias = ['Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miércoles','Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sábado','Sunday'=>'Domingo'];
        $diaSemana = $dias[$fechaObj->format('l')];
        $fechaFormateada = $fechaObj->format('d/m/Y');
       ?>
       <tr class="excepcion">
        <td><span class="fecha"><?= $fechaFormateada ?></span></td>
        <td><?= $diaSemana ?></td>
        <td><?= htmlspecialchars($feriado['motivo']) ?></td>
       </tr>
      <?php endforeach; ?>
     </tbody>
    </table>
   <?php else: ?>
    <p style="text-align:center;">No hay excepciones activas.</p>
   <?php endif; ?>

      <h2 class="card-title" style="margin-top:2rem;">Feriados Nacionales</h2>
   <?php if(!empty($feriadosNacionales)): ?>
    <table class="tabla-feriados">
     <thead>
      <tr>
       <th>Fecha</th>
       <th>Día</th>
       <th>Motivo</th>
      </tr>
     </thead>
     <tbody>
      <?php foreach($feriadosNacionales as $feriado): ?>
       <?php 
        $fechaObj = new DateTime($feriado['fecha']);
        $dias = ['Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miércoles','Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sábado','Sunday'=>'Domingo'];
        $diaSemana = $dias[$fechaObj->format('l')];
        $fechaFormateada = $fechaObj->format('d/m/Y');
       ?>
       <tr class="feriado">
        <td><span class="fecha"><?= $fechaFormateada ?></span></td>
 <td><?= $diaSemana ?></td>
        <td><?= htmlspecialchars($feriado['motivo']) ?></td>
       </tr>
      <?php endforeach; ?>
     </tbody>
    </table>
   <?php else: ?>
    <p style="text-align:center;">No hay feriados nacionales activos.</p>
   <?php endif; ?>

  <?php else: ?>
   <p style="text-align:center; color: var(--color-danger); font-weight:bold;">No tienes un dispositivo asociado, no puedes ver los feriados.</p>
  <?php endif; ?>

 </div>
</main>

<footer class="footer">
 <p>Tesis timbre automático 2025 <br>Marquez Juan - Mondino Xiomara</p>
</footer>

</body>
</html>