-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2025 a las 05:40:42
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_dental`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `appointments`
--

CREATE TABLE `appointments` (
  `id` int(10) UNSIGNED NOT NULL,
  `treatment_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `illness` varchar(255) NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('pendiente','atendida','cancelada') NOT NULL DEFAULT 'pendiente',
  `paid` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `appointments`
--

INSERT INTO `appointments` (`id`, `treatment_id`, `doctor_id`, `patient_id`, `date`, `time`, `illness`, `cost`, `created_at`, `status`, `paid`) VALUES
(9, 4, 6, 5, '2025-06-12', '14:37:00', 'sdhhsd', 333.00, '2025-06-22 14:35:27', 'pendiente', 0.00),
(23, 3, 6, 5, '2025-06-27', '18:31:00', 'rrrrrrrrrrrr', 554.00, '2025-06-23 18:27:26', 'pendiente', 554.00),
(25, 5, 6, 5, '2025-06-26', '19:30:00', 'ttttt', 43.00, '2025-06-23 19:26:21', 'atendida', 37.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `specialty_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `dni`, `specialty_id`, `address`, `phone`, `email`, `created_at`) VALUES
(6, 'julio lopez', '123456', 1, 'regsegresg', '977675651', 'cruzmaster18full@gmail.com', '2025-06-22 00:55:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `odontograms`
--

CREATE TABLE `odontograms` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(11) NOT NULL,
  `appointment_id` int(10) UNSIGNED NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `document_type` varchar(20) DEFAULT NULL,
  `document_number` varchar(50) DEFAULT NULL,
  `dob` date NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `under_treatment` tinyint(1) NOT NULL DEFAULT 0,
  `bleeding` tinyint(1) NOT NULL DEFAULT 0,
  `allergic` tinyint(1) NOT NULL DEFAULT 0,
  `hypertensive` tinyint(1) NOT NULL DEFAULT 0,
  `diabetic` tinyint(1) NOT NULL DEFAULT 0,
  `pregnant` tinyint(1) NOT NULL DEFAULT 0,
  `motive` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `referred_by` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `patients`
--

INSERT INTO `patients` (`id`, `name`, `document_type`, `document_number`, `dob`, `phone`, `under_treatment`, `bleeding`, `allergic`, `hypertensive`, `diabetic`, `pregnant`, `motive`, `diagnosis`, `observations`, `referred_by`, `email`, `address`, `created_at`) VALUES
(4, 'Nerio Cruz Ayquipa', 'DNI', '45249362', '2001-11-21', '914006847', 0, 0, 0, 0, 0, 0, 'sdgsdg', 'sgrgege', 'redgreg', 'nerio', 'vip2025tc@nerio18pe.com', 'Nuevosadacfa', '2025-06-21 20:33:19'),
(5, 'Juana Ayquipa', 'DNI', '76754922', '1998-05-12', '977675651', 0, 0, 0, 0, 0, 0, 'fcghdyth', 'hdfthtrd', 'dtrh', 'nerio', 'cruzmaster18full@gmail.com', 'trshtrszfh', '2025-06-21 20:34:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `appointment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT 'Usuario que registró el pago',
  `amount` decimal(10,2) NOT NULL COMMENT 'Monto pagado',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora del pago'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `payments`
--

INSERT INTO `payments` (`id`, `appointment_id`, `user_id`, `amount`, `created_at`) VALUES
(1, 25, 2, 5.00, '2025-06-26 00:32:58'),
(2, 25, 2, 2.00, '2025-06-26 00:33:19'),
(3, 9, 2, 100.00, '2025-06-26 00:33:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(50) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`) VALUES
(1, 'clinic_name', 'Mi Clínica Dental', '2025-06-21 18:01:57'),
(2, 'clinic_address', 'Av. Principal 123', '2025-06-21 18:01:57'),
(3, 'clinic_phone', '0123-456789', '2025-06-21 18:01:57'),
(4, 'currency', 'S/.', '2025-06-21 18:01:57'),
(5, 'timezone', 'America/Lima', '2025-06-21 18:01:57'),
(6, 'clinic_email', 'contacto@clinica.com', '2025-06-21 18:03:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `specialties`
--

CREATE TABLE `specialties` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `specialties`
--

INSERT INTO `specialties` (`id`, `name`, `created_at`) VALUES
(1, 'Ortodoncia', '2025-06-21 18:03:16'),
(2, 'Endodoncia', '2025-06-21 18:03:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `treatments`
--

CREATE TABLE `treatments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `treatments`
--

INSERT INTO `treatments` (`id`, `name`, `price`, `created_at`) VALUES
(3, 'wefwef', 554.00, '2025-06-22 01:37:51'),
(4, 'wefwe', 333.00, '2025-06-22 02:02:13'),
(5, 'grwegwg', 43.00, '2025-06-22 02:06:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dentist','assistant') NOT NULL DEFAULT 'assistant',
  `document_type` varchar(20) DEFAULT NULL,
  `document_number` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `document_type`, `document_number`, `email`, `phone`, `created_at`) VALUES
(2, 'admin', '$2y$10$kr2rInFQkgqvWR4SGiqh0uprQpKmxyP6VKIhXTsRSwblh4oqzZTtW', 'admin', 'DNI', '12345678', 'admin@gmail.com', '957716730', '2025-06-21 18:39:29'),
(3, 'nerio', '$2y$10$H9xnbDpRwcY2r4eG4EJAi.rCoe1uuX1OQxWos3/EgXcTzbPD2Mxou', 'admin', 'DNI', '45249362', 'cruzmaster18full@gmail.com', '914006847', '2025-06-21 20:09:29'),
(4, 'juan', '$2y$10$PMT8OoNfGyNrDfwps98ojesjcbZ9lel2E9t7chcxlhYlJBggoiAfC', 'dentist', 'DNI', '76754922', 'cruzmaster18full@gmail.com', '977675651', '2025-06-22 03:40:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_appointments_treatment` (`treatment_id`),
  ADD KEY `idx_appointments_doctor` (`doctor_id`),
  ADD KEY `idx_appointments_patient` (`patient_id`);

--
-- Indices de la tabla `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doctors_specialty` (`specialty_id`);

--
-- Indices de la tabla `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoices_patient` (`patient_id`);

--
-- Indices de la tabla `odontograms`
--
ALTER TABLE `odontograms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_odontograms_patient` (`patient_id`),
  ADD KEY `idx_odontograms_appointment` (`appointment_id`),
  ADD KEY `idx_odontograms_doctor` (`doctor_id`);

--
-- Indices de la tabla `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pay_appointment` (`appointment_id`),
  ADD KEY `idx_pay_user` (`user_id`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indices de la tabla `specialties`
--
ALTER TABLE `specialties`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `odontograms`
--
ALTER TABLE `odontograms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `specialties`
--
ALTER TABLE `specialties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_appointments_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_appointments_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_appointments_treatment` FOREIGN KEY (`treatment_id`) REFERENCES `treatments` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`specialty_id`) REFERENCES `specialties` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_doctors_specialty` FOREIGN KEY (`specialty_id`) REFERENCES `specialties` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_invoices_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `odontograms`
--
ALTER TABLE `odontograms`
  ADD CONSTRAINT `fk_odontograms_appointment` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_odontograms_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_odontograms_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_appointment` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_payments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
