CREATE DATABASE IF NOT EXISTS contact_tracing;
USE contact_tracing;

-- Visitors table: stores unique visitor profiles
CREATE TABLE visitors (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  id_number       VARCHAR(50) UNIQUE,           -- USC ID (NULL for guests)
  first_name      VARCHAR(100) NOT NULL,
  last_name       VARCHAR(100) NOT NULL,
  barangay        VARCHAR(100),
  city            VARCHAR(100),
  province        VARCHAR(100),
  contact_number  VARCHAR(20) NOT NULL,         -- Normalized to digits only
  created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX idx_id_number (id_number),
  INDEX idx_contact (contact_number)
);

-- Visit logs: tracks each sign-in/sign-out event
CREATE TABLE visit_logs (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  visitor_id      INT NOT NULL,
  sign_in         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  sign_out        TIMESTAMP NULL,
  location        VARCHAR(100) DEFAULT 'CpE Office',

  FOREIGN KEY (visitor_id) REFERENCES visitors(id) ON DELETE CASCADE,
  INDEX idx_visitor (visitor_id),
  INDEX idx_sign_in (sign_in)
);

-- Admin table: single admin account
CREATE TABLE admins (
  id              INT PRIMARY KEY AUTO_INCREMENT,
  username        VARCHAR(50) UNIQUE NOT NULL,
  password        VARCHAR(255) NOT NULL,
  created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin account created via setup script (not seeded here for security)
