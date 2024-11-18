function calcularPrecio() {
    const valorUnitario = parseFloat(document.getElementById('valorunitario').value) || 0;
    const descuentoPorcentaje = parseFloat(document.getElementById('pordescu').value) || 0; // Descuento en porcentaje
    const iva = 0.19; // 19% IVA
    const aplicacion = 0.07; // 7% para el aplicativo

    // Cálculo del descuento
    const descuento = (valorUnitario * descuentoPorcentaje) / 100;

    // Cálculo del precio final
    let precio = valorUnitario + (valorUnitario * iva) + (valorUnitario * aplicacion) - descuento;

    // Mostrar precio en el input
    document.getElementById('precio').value = precio.toFixed(2);

    // Mostrar desglose con formato
    if (isNaN(valorUnitario) || valorUnitario < 0) {
        document.getElementById('detalle').innerHTML = "<strong>Ingresa el valor unitario</strong>";
        document.getElementById('precio').value = ""; // Limpiar el campo de precio
        return; // Salir de la función
    }
    const desglose = `
        <b>Valor Unitario:</b> $${valorUnitario.toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}<br>
        <b>IVA (19%):</b> $${(valorUnitario * iva).toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}<br>
        <b>Comisión Aplicativo (7%):</b> $${(valorUnitario * aplicacion).toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}<br>
        <b>Descuento (${descuentoPorcentaje}%):</b> -$${descuento.toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}<br>
        <strong>Precio Final: $${precio.toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</strong>
    `;
    document.getElementById('detalle').innerHTML = desglose;
}
let selectedFiles = [];
function actualizarOrden() {
    const input = document.getElementById('imgpro');
    const ordenContenedor = document.getElementById('orden-imagenes');
    const files = input.files;

    // Añadir las nuevas imágenes seleccionadas al array
    for (let i = 0; i < files.length; i++) {
        if (!selectedFiles.includes(files[i])) {
            selectedFiles.push(files[i]);  // Añadir archivo al array si no está ya
        }
    }

    // Limpiar el contenedor antes de agregar las nuevas imágenes
    ordenContenedor.innerHTML = "";

    // Mostrar todas las imágenes en selectedFiles (nuevas y antiguas)
    selectedFiles.forEach((archivo, index) => {
        const reader = new FileReader();

        reader.onload = (e) => {
            const imgDiv = document.createElement('div');
            imgDiv.classList.add('col', 'imagen-preview');

            imgDiv.innerHTML = `
                <img src="${e.target.result}" alt="Imagen ${index + 1}" class="img-thumbnail" style="max-width: 100px; margin: 5px;">
                <label>
                    <input type="radio" name="imagenPrincipal" value="${index}" ${index === 0 ? "checked" : ""}>
                    Principal
                </label>
                <button type="button" onclick="eliminarImagen(${index})" class="btn-del"><i class="bi bi-x-circle-fill"></i></button>
            `;
            ordenContenedor.appendChild(imgDiv);
        };

        reader.readAsDataURL(archivo);
    });
}
function eliminarImagen(index) {
    // Eliminar la imagen del array
    selectedFiles.splice(index, 1);

    // Limpiar el input file
    const input = document.getElementById('imgpro');
    input.value = '';  // Vaciar el campo input de tipo file

    // Reasignar los archivos restantes al input
    for (let i = 0; i < selectedFiles.length; i++) {
        let dataTransfer = new DataTransfer();
        dataTransfer.items.add(selectedFiles[i]); // Agregar el archivo al DataTransfer
        input.files = dataTransfer.files; // Asignar el nuevo array de archivos
    }

    // Volver a actualizar la vista
    actualizarOrden();
}
function nextStep(step) {
    // Ocultar todos los pasos
    for (let i = 1; i <= 4; i++) {
        document.getElementById('step' + i).style.display = 'none';
    }
    // Mostrar el paso actual
    document.getElementById('step' + step).style.display = 'block';
}
function cantCr() {
    let cant = document.getElementById('cantcr').value; // Cantidad de inputs a generar
    let bx = document.getElementById('descar');        // Contenedor para los inputs
    bx.innerHTML = ""; // Limpiar el contenido antes de agregar los nuevos inputs

    for (let i = 0; i < cant; i++) {
        bx.innerHTML += `<input type="text" name="descripcioncr[]" id="" placeholder="Característica ${i + 1}"><br>`;
    }
}

window.addEventListener('load', () => {
    document.getElementById('valorunitario').addEventListener('input', calcularPrecio);
    document.getElementById('pordescu').addEventListener('input', calcularPrecio);
});
