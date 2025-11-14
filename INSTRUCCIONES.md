# Instrucciones de Instalación - Sistema de Inscripción HTECH

## 1. Configurar la Base de Datos

### Opción A: Usando phpMyAdmin (Recomendado)

1. Abre tu navegador y ve a: `http://localhost/phpmyadmin`
2. Haz clic en la pestaña **"SQL"** en el menú superior
3. Abre el archivo `database.sql` con un editor de texto
4. Copia TODO el contenido del archivo
5. Pégalo en el área de texto de phpMyAdmin
6. Haz clic en el botón **"Continuar"** o **"Go"**
7. Verifica que las tablas se hayan creado correctamente

### Opción B: Usando la línea de comandos de MySQL

```bash
mysql -u root -p < database.sql
```

### Opción C: Importar desde phpMyAdmin

1. Abre phpMyAdmin: `http://localhost/phpmyadmin`
2. Haz clic en **"Importar"** en el menú superior
3. Haz clic en **"Seleccionar archivo"**
4. Selecciona el archivo `database.sql`
5. Haz clic en **"Continuar"** al final de la página

## 2. Verificar la Configuración de Conexión

Abre el archivo `conexion.php` y verifica que los datos sean correctos:

```php
define('DB_HOST', 'localhost');      // Servidor MySQL
define('DB_NAME', 'phpmyadmin');     // Nombre de la base de datos
define('DB_USER', 'root');           // Usuario de MySQL
define('DB_PASS', '');               // Contraseña de MySQL (vacía por defecto)
```

**IMPORTANTE:** Si tu usuario o contraseña de MySQL son diferentes, actualiza estos valores.

## 3. Iniciar el Servidor

### Opción A: Usando XAMPP
1. Abre el Panel de Control de XAMPP
2. Inicia **Apache** y **MySQL**
3. Abre tu navegador en: `http://localhost/PruebaPractica/index.php`

### Opción B: Usando WAMP
1. Inicia WAMP
2. Verifica que el icono esté en verde
3. Abre tu navegador en: `http://localhost/PruebaPractica/index.php`

### Opción C: Usando servidor PHP integrado
```bash
cd /ruta/a/PruebaPractica
php -S localhost:8000
```
Luego abre: `http://localhost:8000/index.php`

## 4. Probar el Formulario

1. Llena todos los campos del formulario:
   - Nombre
   - Apellido
   - Edad
   - Sexo
   - **Fecha de Nacimiento** (haz clic para abrir el calendario)
   - País de Residencia
   - Nacionalidad
   - Selecciona al menos una tecnología
   - Observaciones (opcional)

2. Haz clic en **"Enviar Inscripción"**

3. Si todo está correcto, verás un mensaje verde de éxito

## Estructura de la Base de Datos

El sistema utiliza 3 tablas relacionadas:

- **datos_inscriptor**: Almacena información básica (nombre, apellido, edad, sexo)
- **datos_pais**: Almacena país de residencia y nacionalidad
- **datos_areas_interes**: Almacena las tecnologías seleccionadas y observaciones

## Paleta de Colores Utilizada

- **Azul Principal**: #40ABDD
- **Turquesa/Cyan**: #40DDC1
- Gradiente: De azul a turquesa

## Solución de Problemas

### Error: "Table doesn't exist"
- Ejecuta el archivo `database.sql` para crear las tablas

### Error: "Access denied"
- Verifica usuario y contraseña en `conexion.php`
- Asegúrate de que MySQL esté corriendo

### El datepicker no aparece
- Verifica que estés usando un navegador moderno (Chrome, Firefox, Edge, Safari)
- El campo de fecha es HTML5 nativo

### Las validaciones no funcionan
- Verifica que el archivo `validaciones.js` esté cargando correctamente
- Abre la consola del navegador (F12) para ver errores

## Archivos del Proyecto

- `index.php` - Formulario principal con datepicker
- `guardar.php` - Procesa y guarda los datos
- `conexion.php` - Configuración de base de datos
- `validaciones.js` - Validaciones JavaScript
- `estilos.css` - Estilos y diseño
- `database.sql` - Script de creación de base de datos
- `reporte.php` - Reporte de inscripciones

---
**HTECH © 2025** | Sistema de Inscripción para Tecnologías
