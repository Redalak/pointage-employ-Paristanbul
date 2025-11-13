-- Schema for attendance app (compatible with MAMP/WAMP).
SET time_zone = '+01:00';

CREATE TABLE IF NOT EXISTS employees (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(200) NOT NULL,
  qr_token VARCHAR(64) NOT NULL UNIQUE,
  role ENUM('admin','employee') NOT NULL DEFAULT 'employee',
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS clock_sessions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  employee_id INT NOT NULL,
  day_date DATE NOT NULL,
  started_at DATETIME NOT NULL,
  ended_at DATETIME NULL,
  minutes_worked INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_clock_employee FOREIGN KEY (employee_id) REFERENCES employees(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX idx_employee_day (employee_id, day_date),
  INDEX idx_open_session (employee_id, ended_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
