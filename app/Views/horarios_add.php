<!-- app/Views/horarios_add.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Horario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <style>
    
    body {
  min-height: 100vh;
  display: flex;
  flex-direction: column; /* Columnas: navbar, contenido, footer */
  background-color: #091342;
  margin: 0;
  padding-top: 80px; /* espacio para la navbar */
}

main {
  flex: 1; /* Ocupa todo el espacio disponible */
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px 0; /* espacio arriba y abajo */
}

.footer {
  position: relative; /* Quita el absolute para que no flote */
  width: 100%;
  text-align: center;
  padding: 0.3rem;
  background-color: #081136;
  font-weight: bold;
  color: white;
}

  .card {
    background: #081136;
    color: white;
    width: 30rem; /* mismo ancho que Modificar */
    border-radius: 1.5rem;
    box-shadow: 0px 8px 50px rgba(0, 0, 0, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.05);
    position: relative;
  }

    .card-body {
      margin-top: -45px;
      padding: 1.5rem;
    }

    .navbar {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #081136;
      padding: 1rem 2rem;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 9999;
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

    .volver-btn:hover,
    .volver-btn:active,
    .volver-btn:focus {
      background-color: transparent;
      color: white;
      outline: none;
    }

    .container {
      padding-top: 80px;
    }

    .alert {
      margin-bottom: 1rem;
      padding: 0.75rem 1rem;
      border-radius: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
      font-weight: 100;
      font-size: 1rem;
      background-color: rgba(220, 38, 38, 0.15);
      border: 1.5px solid rgba(220, 38, 38, 0.6);
      color: #dc2626;
    }

    label {
      text-align: left;
      display: block;
      margin-bottom: 0.4rem;
      margin-left: 0;
      font-weight: 500;
    }

    .form-control {
      width: 100%;
      padding: 0.6rem 1rem;
      background-color: transparent;
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 8px;
      color: white;
      font-size: 1rem;
      margin-bottom: 1rem;
      transition: all 0.3s ease;
    }

    .form-control::placeholder {
      color: #bbb;
    }

    .form-control:focus {
      background-color: rgba(255, 255, 255, 0.08);
      color: #bbb;
      border: 1px solid #6f42c1;
      box-shadow: 0 0 10px #6f42c1;
      caret-color: #bbb;
    }

    input:-webkit-autofill,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:active {
      -webkit-text-fill-color: #fff;
      transition: background-color 9999s ease-in-out 0s;
      -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset;
      caret-color: #fff;
    }

    input:-moz-autofill {
      box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.05) inset;
      -moz-text-fill-color: #fff;
      caret-color: #fff;
    }

    .btn-submit {
      background-color: #070f2e;
      color: white;
      padding: 0.4rem 1.7rem;
      font-size: 1.1rem;
      border: none;
      border-radius: 5px;
    }

    .btn-submit:hover {
      background-color: #666565;
    }
  </style>

  <!-- Navbar -->
  <nav class="navbar sticky-top">
    <img src="http://localhost/juanxiomaram2024/tesina2025/fondo/prueba.png" width="60px" alt="Logo">
    <div class="logo">RingMind</div>
    <div class="navbar-buttons">
      <form action="<?= base_url('/horarios'); ?>" method="get">
        <button type="submit" class="btn btn-sm volver-btn">Volver</button>
      </form>
    </div>
  </nav>
<main>
  <div class="card">
    <div class="card-body">
      <div class="container text-center">
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('error') ?>
          </div>
        <?php endif; ?>

        <div class="row justify-content-md-center">
          <div class="col-md-10">
            <h3>Agregar horarios</h3>
            <form action="<?= base_url('horarios/add') ?>" method="post">
              <div class="mb-3">
                <label for="evento">Evento:</label>
                <input type="text" name="evento" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="hora">Hora:</label>
                <input type="time" name="hora" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="iddia">Día de la semana:</label>
                <select name="iddia" class="form-control" required>
                  <option value="">-- Seleccionar día --</option>
                  <option value="1">Lunes</option>
                  <option value="2">Martes</option>
                  <option value="3">Miércoles</option>
                  <option value="4">Jueves</option>
                  <option value="5">Viernes</option>
                  <option value="6">Sábado</option>
                  <option value="7">Domingo</option>
                </select>
              </div>

              <div class="text-center">
                <button type="submit" class="btn-submit">Agregar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </main>
  <!-- Footer -->
  <footer class="footer">
    <p>Tesis timbre automático 2025 <br> Marquez Juan - Mondino Xiomara</p>
  </footer>
</body>
</html>
