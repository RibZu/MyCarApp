/**
 * MyCarApp Administration Panel Scripts
 */

document.addEventListener("DOMContentLoaded", function() {
    
  
    const checkAll = document.getElementById('checkAll');
    if (checkAll) {
        checkAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.vehicle-check');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    }

  
    const fileInput = document.querySelector('.upload-file-input');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const titleEl = document.querySelector('.upload-title');
            const iconEl = document.querySelector('.upload-dropzone i');
            if (fileName) {
                if (titleEl) titleEl.innerHTML = 'Archivo seleccionado: <strong class="text-primary">' + fileName + '</strong>';
                if (iconEl) {
                    iconEl.className = 'bi bi-file-earmark-image-fill text-success';
                }
            }
        });
    }

   
    const successModalEl = document.getElementById('successModal');
    if (successModalEl) {
        const myModal = new bootstrap.Modal(successModalEl);
        myModal.show();
    }

    // Confirmación de Baja lógica
    const confirmarBajaModal = document.getElementById('confirmarBajaModal');
    if (confirmarBajaModal) {
        confirmarBajaModal.addEventListener('show.bs.modal', function (event) {
            // Botón que disparó el modal
            const button = event.relatedTarget;
            // Extraer la URL directamente del atributo href del botón
            const url = button.getAttribute('href');
            // Actualizar el href del botón "Confirmar" dentro del modal
            const confirmBtn = confirmarBajaModal.querySelector('#btnConfirmarBajaAceptar');
            if (confirmBtn) {
                confirmBtn.setAttribute('href', url);
            }
        });
    }
});
