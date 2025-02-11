
USE jastiebl;

-- Table: admins
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admins` (`id`, `name`, `email`, `profile_image`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', 'uploads/66c9e734ebbed.jpg', '$2y$12$WcvxEV3ZFz1u4iyN8nmPTuacg9fbHE92lik5EZILFRaFLA/JeYrNe', '2024-07-27 21:57:49', '2024-11-16 14:52:32');

-- Table: clients
CREATE TABLE `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
   `Hours` INT DEFAULT 0,  
  `Vacation Days` INT DEFAULT 0, 
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `clients` (`id`, `name`, `email`, `profile_image`, `phone_no`, `password`, 'Hours', 'Vacation Days', `created_at`, `updated_at`) VALUES
(1, 'Asad', 'client@gmail.com', 'uploads/66cc1ceb88cef.png', '0314443333333', 'abc123', '2024-08-26 06:12:59', '2024-11-18 18:26:26'),
(4, 'client', 'cajehawaj@mailinator.com', NULL, NULL, '$2y$10$CzVeaBOqcKCify4dyUHorOXueO.oQKERGsiGGaHeVAYwKKsboyGei', 40, 5, '2024-11-18 18:16:45', '2024-11-18 18:25:55'),
(5, 'testing', 'clients@gmail.com', NULL, NULL, '$2y$12$WcvxEV3ZFz1u4iyN8nmPTuacg9fbHE92lik5EZILFRaFLA/JeYrNe', 35, 8, '2024-11-19 01:43:09', '2024-11-20 13:26:07');

-- Table: employees
CREATE TABLE `employees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `employees` (`id`, `name`, `email`, `profile_image`, `phone_no`, `password`, `created_at`, `updated_at`) VALUES
(2, 'jyfepod', 'employee@gmail.com', NULL, NULL, '$2y$12$WcvxEV3ZFz1u4iyN8nmPTuacg9fbHE92lik5EZILFRaFLA/JeYrNe', '2024-11-18 17:52:10', '2024-11-18 18:38:33'),
(3, 'danalu', 'fydihyca@mailinator.com', NULL, NULL, '$2y$10$62Q6ZfGv561pwjOaYTsEvutiCQJyIgoFr7IS7fMzDWNGAFcy4IkSG', '2024-11-18 18:36:49', '2024-11-18 18:36:49'),
(4, 'sycawirot', 'employees@gmail.com', NULL, NULL, '$2y$10$KPBWcHLYxEe6rv2n/VBmvufCpXDfs6vcMkcSTstCI1SxEQW7exZnS', '2024-11-19 01:43:50', '2024-11-19 01:43:50');

-- Table: suppliers
CREATE TABLE `suppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `phone_no` varchar(50) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `suppliers` (`id`, `name`, `phone_no`, `address`, `created_at`) VALUES
(2, 'Sierra Vargas', '+1 (516) 713-1194', 'Magnam aut quasi tem', '2024-11-20 05:25:19');

-- Table: inventory
CREATE TABLE `inventory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `supplier_id` int DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `inventory` (`id`, `supplier_id`, `product_name`, `quantity`, `price`, `product_image`, `created_at`) VALUES
(1, 2, 'Ursula Parks', 480, 613.00, 'WhatsApp Image 2024-11-17 at 3.56.01 PM.jpeg', '2024-11-20 05:38:43'),
(2, 2, 'Lillith Ortega', 654, 755.00, 'IMG_3422.PNG', '2024-11-20 05:46:08'),
(3, 2, 'Macy Shelton', 212, 560.00, 'WhatsApp Image 2024-11-19 at 6.35.17 PM.jpeg', '2024-11-20 05:47:35');

-- Table: tasks
CREATE TABLE `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `client_id` int DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','in-progress','completed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tasks` (`id`, `employee_id`, `client_id`, `title`, `description`, `due_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 5, 'contact client12', 'test12', '2024-11-20', 'in-progress', '2024-11-20 12:34:10', '2024-11-20 13:10:44'),
(2, 4, 5, 'contact client12', 'test12', '2024-11-20', 'in-progress', '2024-11-20 12:34:10', '2024-11-20 13:15:56');


-- SQL code to create the estimates table
CREATE TABLE `estimates` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NOT NULL, -- Foreign key to link to clients
  `description` TEXT NOT NULL,
  `amount` DECIMAL(10, 2) NOT NULL,
  `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  `pdf_path` VARCHAR(255) DEFAULT NULL, -- Column for storing PDF file path
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample data into estimates table
INSERT INTO `estimates` (`client_id`, `description`, `amount`, `status`, `pdf_path`, `created_at`, `updated_at`)
VALUES 
(1, 'Description for estimate 1', 1500.00, 'pending', 'uploads/estimate1.pdf', NOW(), NOW()),
(2, 'Description for estimate 2', 2300.00, 'approved', 'uploads/estimate2.pdf', NOW(), NOW());


CREATE TABLE estimate_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    services TEXT NOT NULL,
    additional_services TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

-- Insert sample data
INSERT INTO estimate_requests (client_id, services, additional_services, status, created_at) 
VALUES 
(1, 'Audio System Installation, Lighting Solutions', 'Need a quote ASAP.', 'pending', NOW()),
(2, 'Networking Solutions', 'Install for new office', 'approved', NOW()),
(3, 'Home Theater Systems, Security Solutions', 'High-end setup required.', 'rejected', NOW());
