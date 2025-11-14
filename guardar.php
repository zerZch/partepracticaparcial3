<?php
/**
 * Archivo para guardar datos del formulario
 * Procesa los datos de inscripción y los guarda en la base de datos
 */

// Incluir archivo de conexión
require_once 'conexion.php';

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// Iniciar sesión para mensajes
session_start();

try {
    // Crear instancia de la clase Conexion
    $db = new Conexion();
    $conexion = $db->getConexion();

    // Iniciar transacción
    $db->iniciarTransaccion();

    // Validar y limpiar datos del inscriptor
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $edad = intval($_POST['edad'] ?? 0);
    $sexo = trim($_POST['sexo'] ?? '');
    $fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');

    // Capitalizar nombres y apellidos (primera letra de cada palabra en mayúscula)
    $nombre = ucwords(strtolower($nombre));
    $apellido = ucwords(strtolower($apellido));

    // Validar datos básicos
    if (empty($nombre) || empty($apellido) || $edad <= 0 || empty($sexo)) {
        throw new Exception("Todos los campos básicos son requeridos.");
    }

    // Validar edad
    if ($edad < 1 || $edad > 120) {
        throw new Exception("La edad debe estar entre 1 y 120 años.");
    }

    // Validar que nombre y apellido solo contengan letras
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
        throw new Exception("El nombre solo debe contener letras.");
    }

    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $apellido)) {
        throw new Exception("El apellido solo debe contener letras.");
    }

    // Insertar datos del inscriptor
    $sqlInscriptor = "INSERT INTO datos_inscriptor (nombre, apellido, edad, sexo)
                      VALUES (:nombre, :apellido, :edad, :sexo)";
    $stmtInscriptor = $db->preparar($sqlInscriptor);
    $stmtInscriptor->execute([
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':edad' => $edad,
        ':sexo' => $sexo
    ]);

    // Obtener el ID del inscriptor recién insertado
    $inscriptorId = $db->obtenerUltimoId();

    // Insertar datos de país
    $paisResidencia = trim($_POST['pais'] ?? '');
    $nacionalidad = trim($_POST['nacionalidad'] ?? '');

    // Capitalizar país y nacionalidad
    $paisResidencia = ucwords(strtolower($paisResidencia));
    $nacionalidad = ucwords(strtolower($nacionalidad));

    if (!empty($paisResidencia) && !empty($nacionalidad)) {
        // Validar que solo contengan letras
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $paisResidencia)) {
            throw new Exception("El país de residencia solo debe contener letras.");
        }

        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nacionalidad)) {
            throw new Exception("La nacionalidad solo debe contener letras.");
        }

        $sqlPais = "INSERT INTO datos_pais (inscriptor_id, pais_residencia, nacionalidad)
                    VALUES (:inscriptor_id, :pais_residencia, :nacionalidad)";
        $stmtPais = $db->preparar($sqlPais);
        $stmtPais->execute([
            ':inscriptor_id' => $inscriptorId,
            ':pais_residencia' => $paisResidencia,
            ':nacionalidad' => $nacionalidad
        ]);
    }

    // Insertar tecnologías seleccionadas
    $tecnologias = $_POST['tecnologias'] ?? [];
    $observaciones = trim($_POST['observaciones'] ?? '');

    if (empty($tecnologias) || !is_array($tecnologias)) {
        throw new Exception("Debe seleccionar al menos una tecnología.");
    }

    $sqlInteres = "INSERT INTO datos_areas_interes (inscriptor_id, tecnologia, observaciones)
                   VALUES (:inscriptor_id, :tecnologia, :observaciones)";
    $stmtInteres = $db->preparar($sqlInteres);

    foreach ($tecnologias as $tecnologia) {
        $tecnologia = trim($tecnologia);
        if (!empty($tecnologia)) {
            $stmtInteres->execute([
                ':inscriptor_id' => $inscriptorId,
                ':tecnologia' => $tecnologia,
                ':observaciones' => $observaciones
            ]);
        }
    }

    // Confirmar transacción
    $db->confirmarTransaccion();

    // Mensaje de éxito
    $_SESSION['mensaje'] = "Inscripción registrada exitosamente. Nombre: $nombre $apellido";
    $_SESSION['tipo_mensaje'] = "exito";

    // Cerrar conexión
    $db->cerrar();

    // Redireccionar al formulario
    header('Location: index.php?success=1');
    exit();

} catch (Exception $e) {
    // Revertir transacción en caso de error
    if (isset($db)) {
        $db->revertirTransaccion();
    }

    // Registrar error
    error_log("Error al guardar inscripción: " . $e->getMessage());

    // Mensaje de error
    $_SESSION['mensaje'] = "Error al registrar la inscripción: " . $e->getMessage();
    $_SESSION['tipo_mensaje'] = "error";

    // Cerrar conexión
    if (isset($db)) {
        $db->cerrar();
    }

    // Redireccionar al formulario
    header('Location: index.php?error=1');
    exit();
}
?>
