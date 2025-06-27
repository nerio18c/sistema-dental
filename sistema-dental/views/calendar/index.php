<?php require __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-4">
  <!-- Cabecera blanca con Volver + icono + título -->
  <div class="card mb-3">
    <div class="card-body d-flex align-items-center">
      <a href="?controller=dashboard&action=index" class="btn btn-link text-decoration-none p-0 me-3">
        <i class="bi bi-arrow-left me-1"></i> Volver…
      </a>
      <i class="bi bi-calendar3-fill fs-4 text-primary me-2"></i>
      <h5 class="card-title mb-0">CALENDARIO DE CITAS</h5>
    </div>
  </div>

  <!-- Aquí irá el calendario -->
  <div id="calendar"></div>
</div>

<?php require __DIR__ . '/../templates/footer.php'; ?>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar   = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'es',
      headerToolbar: {
        left:  'prev,next today',
        center:'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week:  'Semana',
        day:   'Día'
      },
      events: {
        url: '?controller=calendar&action=events',
        failure: function() {
          alert('Error al cargar las citas.');
        }
      },
      eventClick: function(info) {
        if (info.event.url) {
          info.jsEvent.preventDefault(); // evita navegación forzada
          window.location.href = info.event.url;
        }
      },
      height: 'auto'
    });
    calendar.render();
  });
</script>
