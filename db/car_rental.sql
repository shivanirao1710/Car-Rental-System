-- Create the database
CREATE DATABASE IF NOT EXISTS car_rental;

-- Use the database
USE car_rental;

-- Table: users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL
);

-- Table: cars
CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL,
    rent_per_day FLOAT NOT NULL,
    status ENUM('Available', 'Booked') DEFAULT 'Available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: bookings
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_amount FLOAT NOT NULL,
    status ENUM('Pending', 'Confirmed', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (car_id) REFERENCES cars(id)
);

-- Table: payments
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    amount_paid FLOAT NOT NULL,
    payment_method ENUM('Cash', 'Card', 'Online') DEFAULT 'Online',
    status ENUM('Pending', 'Completed', 'Failed') DEFAULT 'Pending',
    FOREIGN KEY (booking_id) REFERENCES bookings(id)
);

-- Table: admin_logs
CREATE TABLE IF NOT EXISTS admin_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_action VARCHAR(255) NOT NULL,
    performed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data into users
INSERT INTO users (name, email, password, phone)
VALUES
('John Doe', 'john@example.com', 'password123', '9876543210'),
('Jane Smith', 'jane@example.com', 'password456', '9876501234'),
('Mark Taylor', 'mark@example.com', 'password789', '9876545678'),
('Emily Brown', 'emily@example.com', 'password101', '9876598765'),
('Lucas White', 'lucas@example.com', 'password112', '9876534210');

-- Insert sample data into cars
INSERT INTO cars (name, model, rent_per_day, status)
VALUES
('Toyota Corolla', '2022', 50, 'Available'),
('Honda Civic', '2021', 60, 'Available'),
('Ford Mustang', '2023', 150, 'Available'),
('Tesla Model 3', '2022', 100, 'Available'),
('BMW X5', '2023', 120, 'Available');

-- Insert sample data into bookings
INSERT INTO bookings (user_id, car_id, start_date, end_date, total_amount, status)
VALUES
(1, 1, '2024-01-01', '2024-01-05', 200, 'Confirmed'),
(2, 2, '2024-01-10', '2024-01-15', 300, 'Pending'),
(3, 3, '2024-01-20', '2024-01-22', 450, 'Confirmed'),
(4, 4, '2024-01-25', '2024-01-30', 600, 'Cancelled'),
(5, 5, '2024-02-01', '2024-02-07', 840, 'Confirmed');

-- Insert sample data into payments
INSERT INTO payments (booking_id, amount_paid, payment_method, status)
VALUES
(1, 200, 'Online', 'Completed'),
(2, 300, 'Card', 'Pending'),
(3, 450, 'Cash', 'Completed'),
(4, 0, 'Online', 'Failed'),
(5, 840, 'Online', 'Completed');

-- Insert sample data into admin_logs
INSERT INTO admin_logs (admin_action)
VALUES
('Added a new car: Toyota Corolla'),
('Updated booking status to Confirmed'),
('Deleted a booking for Tesla Model 3'),
('Added a new payment record'),
('Updated car status to Booked');

ALTER TABLE users ADD COLUMN role ENUM('user', 'admin') DEFAULT 'user';

-- Insert sample admin users into users table
INSERT INTO users (name, email, password, phone, role)
VALUES
('Admin One', 'admin1@example.com', 'adminpassword1', '9876500001', 'admin'),
('Admin Two', 'admin2@example.com', 'adminpassword2', '9876500002', 'admin'),
('Admin Three', 'admin3@example.com', 'adminpassword3', '9876500003', 'admin');


-- Create Trigger: Update car status on booking
DELIMITER //
CREATE TRIGGER update_car_status
AFTER INSERT ON bookings
FOR EACH ROW
BEGIN
    UPDATE cars
    SET status = 'Booked'
    WHERE id = NEW.car_id;
END;
//
DELIMITER ;

-- Create Trigger: Log admin actions on payments
DELIMITER //
CREATE TRIGGER log_admin_payment
AFTER INSERT ON payments
FOR EACH ROW
BEGIN
    INSERT INTO admin_logs (admin_action)
    VALUES (CONCAT('Payment record added for booking ID: ', NEW.booking_id));
END;
//
DELIMITER ;
