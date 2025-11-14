<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inscripción - Correo Celular</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <div style="text-align: right; margin-bottom: 10px;">
            <a href="reporte.php" style="color: #40ABDD; text-decoration: none; font-weight: 600;">📊 Ver Reporte de Inscripciones</a>
        </div>
        <h1>Formulario de Inscripción</h1>
        <h2>Tema: Tecnologías que le gustaría aprender Correo Celular (checkbox)</h2>

        <?php
        // Mostrar mensajes de éxito o error
        if (isset($_SESSION['mensaje'])) {
            $tipoMensaje = $_SESSION['tipo_mensaje'] ?? 'error';
            echo '<div class="mensaje ' . htmlspecialchars($tipoMensaje) . '">';
            echo htmlspecialchars($_SESSION['mensaje']);
            echo '</div>';

            // Limpiar mensaje de la sesión
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);
        }
        ?>

        <form id="formularioInscripcion" action="guardar.php" method="POST" onsubmit="return validarFormulario()">
            
            <!-- Campos básicos -->
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>

            <div class="form-group">
                <label for="edad">Edad:</label>
                <input type="number" id="edad" name="edad" min="1" max="120" required>
            </div>

            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo" required>
                    <option value="">Seleccione...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>

            <div class="form-group">
                <label for="pais">País de Residencia:</label>
                <input type="text" id="pais" name="pais" required>
            </div>

            <div class="form-group">
                <label for="nacionalidad">Nacionalidad:</label>
                <input type="text" id="nacionalidad" name="nacionalidad" required>
            </div>

            <!-- Tema: Tecnologías (Checkboxes) -->
            <div class="form-group">
                <label>Tema: Tecnologías que le gustaría aprender Correo Celular:</label>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="tecnologias[]" value="Correo Electrónico"> Correo Electrónico</label>
                    <label><input type="checkbox" name="tecnologias[]" value="Celular"> Celular</label>
                    <label><input type="checkbox" name="tecnologias[]" value="Redes Sociales"> Redes Sociales</label>
                    <label><input type="checkbox" name="tecnologias[]" value="Computación Básica"> Computación Básica</label>
                </div>
            </div>

            <!-- Observaciones o Consulta -->
            <div class="form-group">
                <label for="observaciones">Observaciones o Consulta sobre el evento:</label>
                <textarea id="observaciones" name="observaciones" rows="4"></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Enviar Inscripción</button>
                <button type="reset" class="btn-reset">Limpiar</button>
            </div>
        </form>

        <footer class="footer">
            <p>&copy; <?php echo date('Y'); ?> iTECH. All rights reserved.</p>
            <p>Contacto: info@itech.com | Tel: +507 1234-5678</p>
        </footer>
    </div>

    <script src="validaciones.js"></script>
</body>
</html>