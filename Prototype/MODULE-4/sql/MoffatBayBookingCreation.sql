- Create database
CREATE DATABASE IF NOT EXISTS MoffatBayBooking;
USE MoffatBayBooking;

-- 1. Customer Table
CREATE TABLE Customer (
    customer_id    INT AUTO_INCREMENT PRIMARY KEY,
    first_name     VARCHAR(50)  NOT NULL,
    last_name      VARCHAR(50)  NOT NULL,
    email          VARCHAR(100) NOT NULL UNIQUE,
    phone          VARCHAR(20),
    password_hash  VARCHAR(255) NOT NULL
);

-- 2. Room Type
CREATE TABLE RoomType (
    room_id      INT AUTO_INCREMENT PRIMARY KEY,
    room_name    VARCHAR(50)    NOT NULL,
    room_type    VARCHAR(50)    NOT NULL,
    nightly_rate DECIMAL(10,2)  NOT NULL,
    max_guests   INT            NOT NULL,
    availability_status ENUM('available', 'unavailable', 'maintenance') NOT NULL DEFAULT 'available'
);

-- 3. Reservation Table
CREATE TABLE Reservation (
    reservation_id     INT AUTO_INCREMENT PRIMARY KEY,
    customer_id        INT  NOT NULL,
    room_id            INT  NOT NULL,
    check_in_date      DATE NOT NULL,
    check_out_date     DATE NOT NULL,
    reservation_date   DATE NOT NULL DEFAULT (CURRENT_DATE),  
    total_guests       INT  NOT NULL,
    reservation_status ENUM('pending','confirmed','cancelled','completed') NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id),
    FOREIGN KEY (room_id)     REFERENCES RoomType(room_id)
);

-- 4. Attraction Table
CREATE TABLE Attraction (
    attraction_id   INT AUTO_INCREMENT PRIMARY KEY,
    attraction_name VARCHAR(100) NOT NULL,
    description     TEXT,
    activity_type   VARCHAR(50)
);

-- 5. Reservation_Attraction Bridge Table
CREATE TABLE Reservation_Attraction (
    reservation_id INT NOT NULL,
    attraction_id  INT NOT NULL,
    PRIMARY KEY (reservation_id, attraction_id),
    FOREIGN KEY (reservation_id) REFERENCES Reservation(reservation_id) ON DELETE CASCADE,
    FOREIGN KEY (attraction_id)  REFERENCES Attraction(attraction_id)   ON DELETE CASCADE
);