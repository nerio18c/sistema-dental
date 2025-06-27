<?php
// controllers/PaymentController.php

require_once __DIR__ . '/../models/Payment.php';

class PaymentController
{
    private PDO $pdo;
    private Payment $paymentModel;

    public function __construct(PDO $pdo)
    {
        session_start();
        $this->pdo          = $pdo;
        $this->paymentModel = new Payment($pdo);
    }

    /**
     * Listado principal
     */
    public function index()
    {
        $search  = $_GET['search'] ?? '';
        $entries = $this->paymentModel->getAllAppointmentStatuses($search);
        require __DIR__ . '/../views/payments/list.php';
    }

    /**
     * Ver detalle de pagos de una cita
     */
    public function view()
    {
        $id = intval($_GET['id'] ?? 0);
        if (!$id) {
            header('Location: ?controller=payment&action=index');
            exit;
        }

        // Datos de la cita
        $appointment = $this->paymentModel->getByIdWithDetails($id);

        // Historial de pagos hechos
        $stmt = $this->pdo->prepare("
            SELECT
              p.amount,
              p.created_at,
              u.username AS received_by
            FROM payments p
            JOIN users    u ON p.user_id = u.id
            WHERE p.appointment_id = ?
            ORDER BY p.created_at DESC
        ");
        $stmt->execute([$id]);
        $paymentsList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/payments/view.php';
    }

    /**
     * Recibe el POST del modal, guarda el pago y actualiza la cita
     */
    public function store()
    {
        $appointmentId = intval($_POST['appointment_id'] ?? 0);
        $amount        = floatval($_POST['amount'] ?? 0);
        $userId        = $_SESSION['user']['id'] ?? null;

        if ($appointmentId > 0 && $amount > 0 && $userId) {
            // 1) Inserta el movimiento de pago
            $this->paymentModel->create([
                'appointment_id' => $appointmentId,
                'user_id'        => $userId,
                'amount'         => $amount,
            ]);

            // 2) Actualiza el acumulado en appointments.paid
            $stmt = $this->pdo->prepare("
                UPDATE appointments
                SET paid = paid + :amount
                WHERE id = :id
            ");
            $stmt->execute([
                ':amount' => $amount,
                ':id'     => $appointmentId,
            ]);
        }

        // 3) Redirige al detalle de la cita
        header("Location: ?controller=payment&action=view&id={$appointmentId}");
        exit;
    }
}
