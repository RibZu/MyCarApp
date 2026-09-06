document.addEventListener('DOMContentLoaded', function() {
    // CSS
    const cssOpciones = `
        .fc { --fc-border-color: #f1f5f9; font-family: 'Inter', sans-serif; height: 100% !important; min-height: 400px; }
        .fc .fc-toolbar-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; }
        .fc .fc-button-primary { background-color: #1e293b; border-color: #1e293b; font-weight: 500; font-size: 0.85rem; padding: 6px 12px; border-radius: 8px; }
        .fc .fc-button-primary:hover { background-color: #0f172a; border-color: #0f172a; }
        .fc .fc-button-primary:disabled { background-color: #cbd5e1; border-color: #cbd5e1; }
        .fc .fc-col-header-cell-cushion { color: #475569; font-size: 0.8rem; font-weight: 600; padding: 6px 0; text-decoration: none; }
        .fc .fc-daygrid-day-number { color: #64748b; font-size: 0.85rem; font-weight: 500; padding: 6px; text-decoration: none; }
        .fc-highlight { background: rgba(13, 110, 253, 0.12) !important; }
        .fc .fc-daygrid-day.fc-day-today { background-color: #f8fafc; }
        .fc .fc-daygrid-day-frame { min-height: 55px; }
    `;
    
    // meter css en el head
    const styleTag = document.createElement('style');
    styleTag.textContent = cssOpciones;
    document.head.appendChild(styleTag);


    

    //  LÓGICA DE FULLCALENDAR
    const txtDesde = document.getElementById('fecha_desde');
    const txtHasta = document.getElementById('fecha_hasta');
    const txtDias = document.getElementById('cantidad_dias');
    const lblDias = document.getElementById('lbl-dias');
    const lblTotal = document.getElementById('lbl-total');
    
    const precioDia = parseFloat(document.getElementById('form-reserva').dataset.precioDia);
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        firstDay: 1, 
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'today'
        },
        buttonText: { today: 'Hoy' },
        events: window.eventosOcupados, 
        validRange: {
            start: new Date().toISOString().split('T')[0] 
        },
        selectable: true,
        selectOverlap: function(event) {
            return false; 
        },
        select: function(info) {
            let fechaFinReal = new Date(info.end);
            fechaFinReal.setDate(fechaFinReal.getDate() - 1);
            
            let fechaInicioStr = info.startStr;
            let fechaFinStr = fechaFinReal.toISOString().split('T')[0];

            txtDesde.value = fechaInicioStr;
            txtHasta.value = fechaFinStr;
            
            let diffTiempo = Math.abs(fechaFinReal - info.start);
            let dias = Math.ceil(diffTiempo / (1000 * 60 * 60 * 24)) + 1;
            
            txtDias.value = dias;
            lblDias.innerText = dias + (dias === 1 ? ' día' : ' días');
            

            const total = dias * precioDia;
            const formateadorMoneda = new Intl.NumberFormat('es-AR', {
                style: 'currency',
                currency: 'ARS',
                minimumFractionDigits: 2, 
                maximumFractionDigits: 2
            });

            // Aplicamos el formato al ticket
            lblTotal.innerText = formateadorMoneda.format(total);
        }
    });

    calendar.render();
});