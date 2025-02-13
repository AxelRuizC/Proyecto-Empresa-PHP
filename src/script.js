// Esperar que el contenido del DOM se haya cargado
document.addEventListener("DOMContentLoaded", function () {
    const addTaskButton = document.querySelector(".add-task");  // Botón de añadir tarea
    const tasksContainer = document.querySelector(".tasks");  // Contenedor de tareas

    // Crear una nueva tarea
    addTaskButton.addEventListener("click", function () {
        const newTaskText = prompt("Ingrese el nombre de la nueva tarea:");

        // Si el usuario ingresó texto para la tarea
        if (newTaskText) {
            // Crear el nuevo elemento de tarea
            const newTaskElement = document.createElement("div");
            newTaskElement.classList.add("task");

            // Añadir el contenido de la tarea
            newTaskElement.innerHTML = `
                <span>${newTaskText}</span>
                <button class="delete-task">X</button>
            `;

            // Añadir la tarea al contenedor de tareas
            tasksContainer.appendChild(newTaskElement);

            // Botón de eliminar tarea
            const deleteButton = newTaskElement.querySelector(".delete-task");
            deleteButton.addEventListener("click", function () {
                newTaskElement.remove();  // Eliminar la tarea
            });
        }
    });

    // Agregar Venta
    let btnAgregar = document.querySelector(".abrirAgregar");
    if (btnAgregar) {
        btnAgregar.addEventListener("click", abrirAgregar);
    }

    // Eliminar Venta
    let btnEliminar = document.querySelector(".abrirEliminar");
    if (btnEliminar) {
        btnEliminar.addEventListener("click", abrirEliminar);
    }

    let btnModificar = document.querySelector(".abrirModificar");
    if (btnModificar) {
        btnModificar.addEventListener("click", abrirModificar);
    }
});

function abrirAgregar() {
    let form = document.getElementById("formAgregar");
    if (form) {
        form.style.display = "block";
    }
}

function abrirEliminar() {
    let form = document.getElementById("formEliminar");
    if (form) {
        form.style.display = "block";
    }
}

function abrirModificar() {
    let form = document.getElementById("formModificar");
    if (form) {
        form.style.display = "block";
    }
}
    
function closeForm(formId) {
    let form = document.getElementById(formId);
    if (form) {
        form.style.display = "none";
    } 
};



