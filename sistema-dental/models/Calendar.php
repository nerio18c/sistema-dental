<?php
// models/Calendar.php

require_once __DIR__ . '/BaseModel.php';

class Calendar extends BaseModel
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Obtiene todas las citas formateadas como eventos de FullCalendar
     * @return array
     */
    public function getEvents(): array
    {
        $sql = "
            SELECT
                a.id,
                -- Combina fecha y hora para el inicio del evento
                CONCAT(a.date, 'T', a.time) AS start,
                -- Calcula el fin del evento (ej. 30 minutos después del inicio)
                -- Asegúrate de que esta duración tenga sentido para tus citas
                DATE_FORMAT(
                    DATE_ADD(CONCAT(a.date, ' ', a.time), INTERVAL 30 MINUTE),
                    '%Y-%m-%dT%H:%i:%s'
                ) AS end,
                -- Título del evento mejorado con paciente, doctor y tratamiento
                CONCAT(
                    TIME_FORMAT(a.time, '%H:%i'),
                    ' - ',
                    p.name,
                    ' (Dr. ', d.name, ' - ', t.name, ')'
                ) AS title,
                a.status,    -- Añadimos el estado de la cita para colores
                p.name AS patient_name,
                d.name AS doctor_name,
                t.name AS treatment_name
            FROM appointments a
            JOIN patients p ON a.patient_id = p.id
            JOIN doctors d ON a.doctor_id = d.id       -- Unir con la tabla doctors
            JOIN treatments t ON a.treatment_id = t.id -- Unir con la tabla treatments
        ";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = [];
        foreach ($rows as $r) {
            $color = ''; // Color por defecto
            switch ($r['status']) {
                case 'pendiente':
                    $color = '#2a5298'; // Azul oscuro para citas pendientes
                    break;
                case 'atendida':
                    $color = '#28a745'; // Verde para citas atendidas
                    break;
                case 'cancelada':
                    $color = '#dc3545'; // Rojo para citas canceladas
                    break;
                default:
                    $color = '#6c757d'; // Gris para cualquier otro estado
            }

            $events[] = [
                'id'        => $r['id'],
                'title'     => $r['title'],
                'start'     => $r['start'],
                'end'       => $r['end'],       // Propiedad 'end' crucial para vistas de semana/día
                'url'       => "?controller=appointment&action=edit&id=" . $r['id'],
                'color'     => $color,          // Color del evento basado en el estado
                // Puedes añadir más datos aquí si los necesitas en el frontend, como:
                'extendedProps' => [
                    'patientName'   => $r['patient_name'],
                    'doctorName'    => $r['doctor_name'],
                    'treatmentName' => $r['treatment_name'],
                    'status'        => $r['status']
                ]
            ];
        }
        return $events;
    }
}