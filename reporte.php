<?php
/**
 * Reporte de Inscripciones
 * Muestra todos los datos de los inscritos
 */

// Incluir archivo de conexión
require_once 'conexion.php';

// Crear instancia de la clase Conexion
$db = new Conexion();

// Consulta SQL con JOIN para obtener todos los datos
$sql = "SELECT
            i.id,
            i.nombre,
            i.apellido,
            i.edad,
            i.sexo,
            i.fecha_registro,
            p.pais_residencia,
            p.nacionalidad,
            GROUP_CONCAT(DISTINCT a.tecnologia SEPARATOR ', ') as tecnologias,
            MAX(a.observaciones) as observaciones
        FROM datos_inscriptor i
        LEFT JOIN datos_pais p ON i.id = p.inscriptor_id
        LEFT JOIN datos_areas_interes a ON i.id = a.inscriptor_id
        GROUP BY i.id, i.nombre, i.apellido, i.edad, i.sexo, i.fecha_registro,
                 p.pais_residencia, p.nacionalidad
        ORDER BY i.fecha_registro DESC";

$stmt = $db->ejecutar($sql);
$inscripciones = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inscripciones - iTECH</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        /* Estilos adicionales para el reporte */
        .reporte-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .header-reporte {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .btn-volver {
            background: linear-gradient(135deg, #40ABDD 0%, #40DDC1 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-volver:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(64, 171, 221, 0.5);
        }

        .tabla-reporte {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            overflow-x: auto;
            display: block;
        }

        .tabla-reporte thead {
            background: linear-gradient(135deg, #40ABDD 0%, #40DDC1 100%);
            color: white;
        }

        .tabla-reporte th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border: 1px solid #ddd;
        }

        .tabla-reporte td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        .tabla-reporte tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .tabla-reporte tbody tr:hover {
            background-color: #e9f5ff;
            transition: background-color 0.3s ease;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            background-color: #40DDC1;
            color: white;
            border-radius: 4px;
            font-size: 12px;
            margin: 2px;
        }

        .total-registros {
            margin-top: 20px;
            padding: 15px;
            background: #e9f5ff;
            border-left: 4px solid #40ABDD;
            border-radius: 4px;
            font-weight: 600;
        }

        .no-registros {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 18px;
        }

        .observaciones {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .tabla-reporte {
                font-size: 12px;
            }

            .tabla-reporte th,
            .tabla-reporte td {
                padding: 8px;
            }

            .header-reporte {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="reporte-container">
        <div class="header-reporte">
            <h1>Reporte de Inscripciones</h1>
            <a href="index.php" class="btn-volver">← Volver al Formulario</a>
        </div>

        <?php if (count($inscripciones) > 0): ?>
            <table class="tabla-reporte">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Edad</th>
                        <th>Sexo</th>
                        <th>País</th>
                        <th>Nacionalidad</th>
                        <th>Tecnologías de Interés</th>
                        <th>Observaciones</th>
                        <th>Fecha de Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inscripciones as $inscripcion): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($inscripcion['id']); ?></td>
                            <td>
                                <strong>
                                    <?php echo htmlspecialchars($inscripcion['nombre'] . ' ' . $inscripcion['apellido']); ?>
                                </strong>
                            </td>
                            <td><?php echo htmlspecialchars($inscripcion['edad']); ?> años</td>
                            <td><?php echo htmlspecialchars($inscripcion['sexo']); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion['pais_residencia'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion['nacionalidad'] ?? 'N/A'); ?></td>
                            <td>
                                <?php
                                $tecnologias = explode(', ', $inscripcion['tecnologias'] ?? '');
                                foreach ($tecnologias as $tech) {
                                    if (!empty(trim($tech))) {
                                        echo '<span class="badge">' . htmlspecialchars($tech) . '</span> ';
                                    }
                                }
                                ?>
                            </td>
                            <td class="observaciones" title="<?php echo htmlspecialchars($inscripcion['observaciones'] ?? 'Sin observaciones'); ?>">
                                <?php echo htmlspecialchars($inscripcion['observaciones'] ?? 'Sin observaciones'); ?>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($inscripcion['fecha_registro'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-registros">
                Total de Inscripciones: <?php echo count($inscripciones); ?>
            </div>

        <?php else: ?>
            <div class="no-registros">
                <p>No hay inscripciones registradas todavía.</p>
                <p>Por favor, <a href="index.php">llena el formulario</a> para agregar una nueva inscripción.</p>
            </div>
        <?php endif; ?>

        <footer class="footer">
            <p>&copy; <?php echo date('Y'); ?> iTECH. All rights reserved.</p>
            <p>Contacto: info@itech.com | Tel: +507 1234-5678</p>
        </footer>
    </div>

    <?php
    // Cerrar conexión
    $db->cerrar();
    ?>
</body>
</html>
