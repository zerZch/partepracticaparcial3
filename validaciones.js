/**
 * Archivo de Validaciones JavaScript
 * Valida el formulario antes de enviarlo al servidor
 */

// Función principal de validación
function validarFormulario() {
    // Limpiar mensajes de error previos
    limpiarErrores();

    let esValido = true;

    // Validar nombre
    const nombre = document.getElementById('nombre').value.trim();
    if (nombre === '') {
        mostrarError('nombre', 'El nombre es requerido');
        esValido = false;
    } else if (nombre.length < 2) {
        mostrarError('nombre', 'El nombre debe tener al menos 2 caracteres');
        esValido = false;
    } else if (!validarSoloLetras(nombre)) {
        mostrarError('nombre', 'El nombre solo debe contener letras');
        esValido = false;
    }

    // Validar apellido
    const apellido = document.getElementById('apellido').value.trim();
    if (apellido === '') {
        mostrarError('apellido', 'El apellido es requerido');
        esValido = false;
    } else if (apellido.length < 2) {
        mostrarError('apellido', 'El apellido debe tener al menos 2 caracteres');
        esValido = false;
    } else if (!validarSoloLetras(apellido)) {
        mostrarError('apellido', 'El apellido solo debe contener letras');
        esValido = false;
    }

    // Validar edad
    const edad = parseInt(document.getElementById('edad').value);
    if (isNaN(edad) || edad <= 0) {
        mostrarError('edad', 'La edad debe ser un número válido');
        esValido = false;
    } else if (edad < 1 || edad > 120) {
        mostrarError('edad', 'La edad debe estar entre 1 y 120 años');
        esValido = false;
    }

    // Validar sexo
    const sexo = document.getElementById('sexo').value;
    if (sexo === '') {
        mostrarError('sexo', 'Debe seleccionar un sexo');
        esValido = false;
    }

    // Validar fecha de nacimiento
    const fechaNacimiento = document.getElementById('fecha_nacimiento');
    if (fechaNacimiento && fechaNacimiento.value === '') {
        mostrarError('fecha_nacimiento', 'La fecha de nacimiento es requerida');
        esValido = false;
    } else if (fechaNacimiento && !validarFecha(fechaNacimiento.value)) {
        mostrarError('fecha_nacimiento', 'La fecha de nacimiento no es válida');
        esValido = false;
    }

    // Validar país
    const pais = document.getElementById('pais').value.trim();
    if (pais === '') {
        mostrarError('pais', 'El país de residencia es requerido');
        esValido = false;
    } else if (!validarSoloLetras(pais)) {
        mostrarError('pais', 'El país solo debe contener letras');
        esValido = false;
    }

    // Validar nacionalidad
    const nacionalidad = document.getElementById('nacionalidad').value.trim();
    if (nacionalidad === '') {
        mostrarError('nacionalidad', 'La nacionalidad es requerida');
        esValido = false;
    } else if (!validarSoloLetras(nacionalidad)) {
        mostrarError('nacionalidad', 'La nacionalidad solo debe contener letras');
        esValido = false;
    }

    // Validar tecnologías (al menos una seleccionada)
    const tecnologias = document.querySelectorAll('input[name="tecnologias[]"]:checked');
    if (tecnologias.length === 0) {
        mostrarError('tecnologias', 'Debe seleccionar al menos una tecnología');
        esValido = false;
    }

    // Si hay errores, mostrar mensaje general
    if (!esValido) {
        alert('Por favor, corrija los errores en el formulario antes de continuar.');
    }

    return esValido;
}

// Función para validar solo letras y espacios
function validarSoloLetras(texto) {
    const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
    return regex.test(texto);
}

// Función para validar fecha
function validarFecha(fecha) {
    if (!fecha) return false;

    const fechaObj = new Date(fecha);
    const hoy = new Date();

    // Verificar que sea una fecha válida
    if (isNaN(fechaObj.getTime())) {
        return false;
    }

    // Verificar que la fecha no sea futura
    if (fechaObj > hoy) {
        return false;
    }

    // Verificar que la fecha no sea muy antigua (más de 120 años)
    const hace120Anos = new Date();
    hace120Anos.setFullYear(hace120Anos.getFullYear() - 120);

    if (fechaObj < hace120Anos) {
        return false;
    }

    return true;
}

// Función para mostrar mensajes de error
function mostrarError(campoId, mensaje) {
    const campo = document.getElementById(campoId);
    if (!campo) return;

    // Crear elemento de error si no existe
    let errorDiv = campo.parentElement.querySelector('.error-mensaje');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'error-mensaje';
        campo.parentElement.appendChild(errorDiv);
    }

    // Si es el error de tecnologías, buscarlo de manera diferente
    if (campoId === 'tecnologias') {
        const checkboxGroup = document.querySelector('.checkbox-group');
        if (checkboxGroup) {
            errorDiv = checkboxGroup.parentElement.querySelector('.error-mensaje');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'error-mensaje';
                checkboxGroup.parentElement.appendChild(errorDiv);
            }
        }
    }

    errorDiv.textContent = mensaje;
    campo.classList.add('error');
}

// Función para limpiar errores
function limpiarErrores() {
    // Eliminar mensajes de error
    const errores = document.querySelectorAll('.error-mensaje');
    errores.forEach(error => error.remove());

    // Eliminar clase de error de los campos
    const camposConError = document.querySelectorAll('.error');
    camposConError.forEach(campo => campo.classList.remove('error'));
}

// Validación en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    // Validar nombre en tiempo real
    const nombre = document.getElementById('nombre');
    if (nombre) {
        nombre.addEventListener('blur', function() {
            if (this.value.trim() !== '' && !validarSoloLetras(this.value.trim())) {
                mostrarError('nombre', 'El nombre solo debe contener letras');
            } else {
                const error = this.parentElement.querySelector('.error-mensaje');
                if (error) error.remove();
                this.classList.remove('error');
            }
        });
    }

    // Validar apellido en tiempo real
    const apellido = document.getElementById('apellido');
    if (apellido) {
        apellido.addEventListener('blur', function() {
            if (this.value.trim() !== '' && !validarSoloLetras(this.value.trim())) {
                mostrarError('apellido', 'El apellido solo debe contener letras');
            } else {
                const error = this.parentElement.querySelector('.error-mensaje');
                if (error) error.remove();
                this.classList.remove('error');
            }
        });
    }

    // Validar edad en tiempo real
    const edad = document.getElementById('edad');
    if (edad) {
        edad.addEventListener('blur', function() {
            const edadValor = parseInt(this.value);
            if (!isNaN(edadValor) && (edadValor < 1 || edadValor > 120)) {
                mostrarError('edad', 'La edad debe estar entre 1 y 120 años');
            } else {
                const error = this.parentElement.querySelector('.error-mensaje');
                if (error) error.remove();
                this.classList.remove('error');
            }
        });
    }

    // Validar fecha de nacimiento en tiempo real
    const fechaNacimiento = document.getElementById('fecha_nacimiento');
    if (fechaNacimiento) {
        fechaNacimiento.addEventListener('change', function() {
            if (this.value !== '' && !validarFecha(this.value)) {
                mostrarError('fecha_nacimiento', 'La fecha de nacimiento no es válida o es futura');
            } else {
                const error = this.parentElement.querySelector('.error-mensaje');
                if (error) error.remove();
                this.classList.remove('error');
            }
        });
    }
});
