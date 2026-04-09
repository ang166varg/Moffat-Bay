
-- MoffatBay Booking - Database & Table Creation
-- Bravo Team
-- 4/9/26
-- Creates database and tables for booking and room reservation

CREATE DATABASE IF NOT EXISTS MoffatBayBooking;
USE MoffatBayBooking;


-- Drop tables if they exist (reverse FK order)

DROP TABLE IF EXISTS Reservation_Attraction;
DROP TABLE IF EXISTS Reservation;
DROP TABLE IF EXISTS Attraction;
DROP TABLE IF EXISTS RoomType;
DROP TABLE IF EXISTS Customer;

-- 1. Customer

CREATE TABLE Customer (
    customer_id   INT AUTO_INCREMENT PRIMARY KEY,
    first_name    VARCHAR(50)  NOT NULL,
    last_name     VARCHAR(50)  NOT NULL,
    email         VARCHAR(100) NOT NULL UNIQUE,
    phone         VARCHAR(20),
    password_hash VARCHAR(255) NOT NULL
);


-- 2. RoomType

CREATE TABLE RoomType (
    room_id             INT AUTO_INCREMENT PRIMARY KEY,
    room_name           VARCHAR(50)  NOT NULL,
    room_type           ENUM(
                            'Double Full Beds',
                            'Queen',
                            'Double Queen Beds',
                            'King'
                        ) NOT NULL,
    nightly_rate        DECIMAL(10,2) NOT NULL,
    max_guests          INT           NOT NULL,
    availability_status ENUM('available', 'unavailable', 'maintenance') NOT NULL DEFAULT 'available'
);


-- 3. Attraction

CREATE TABLE Attraction (
    attraction_id   INT AUTO_INCREMENT PRIMARY KEY,
    attraction_name VARCHAR(100) NOT NULL,
    description     TEXT,
    activity_type   VARCHAR(50)
);


-- 4. Reservation

CREATE TABLE Reservation (
    reservation_id     INT AUTO_INCREMENT PRIMARY KEY,
    customer_id        INT           NOT NULL,
    room_id            INT           NOT NULL,
    check_in_date      DATE          NOT NULL,
    check_out_date     DATE          NOT NULL,
    reservation_date   DATE          NOT NULL DEFAULT (CURRENT_DATE),
    total_guests       INT           NOT NULL,
    total_cost         DECIMAL(10,2) NOT NULL,
    reservation_status ENUM('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id),
    FOREIGN KEY (room_id)     REFERENCES RoomType(room_id)
);

-- ------------------------------------------------
-- 5. Reservation_Attraction
-- ------------------------------------------------
CREATE TABLE Reservation_Attraction (
    reservation_id INT NOT NULL,
    attraction_id  INT NOT NULL,
    PRIMARY KEY (reservation_id, attraction_id),
    FOREIGN KEY (reservation_id) REFERENCES Reservation(reservation_id) ON DELETE CASCADE,
    FOREIGN KEY (attraction_id)  REFERENCES Attraction(attraction_id)   ON DELETE CASCADE
);