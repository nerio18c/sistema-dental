<?php
// controllers/CalendarController.php

require_once __DIR__ . '/../models/Calendar.php';

class CalendarController
{
    private PDO $pdo;
    private Calendar $calendarModel;

    public function __construct(PDO $pdo)
    {
        $this->pdo           = $pdo;
        $this->calendarModel = new Calendar($pdo);
    }

    /**
     * Muestra la vista del calendario
     */
    public function index()
    {
        // Simplemente incluimos la vista
        require __DIR__ . '/../views/calendar/index.php';
    }

    /**
     * Devuelve JSON con los eventos para FullCalendar
     */
    public function events()
    {
        header('Content-Type: application/json; charset=utf-8');
        $events = $this->calendarModel->getEvents();
        echo json_encode($events);
    }
}
