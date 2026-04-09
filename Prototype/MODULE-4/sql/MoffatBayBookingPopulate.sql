
-- MoffatBay Booking - Sample Data Population
-- Bravo Team
-- 4/9/26
-- Used as example for populating database tables with example information


USE MoffatBayBooking;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE Reservation_Attraction;
TRUNCATE TABLE Reservation;
TRUNCATE TABLE Attraction;
TRUNCATE TABLE RoomType;
TRUNCATE TABLE Customer;
SET FOREIGN_KEY_CHECKS = 1;

ALTER TABLE Customer              AUTO_INCREMENT = 1;
ALTER TABLE RoomType              AUTO_INCREMENT = 1;
ALTER TABLE Attraction            AUTO_INCREMENT = 1;
ALTER TABLE Reservation           AUTO_INCREMENT = 1;
ALTER TABLE Reservation_Attraction AUTO_INCREMENT = 1;

-- RoomType
-- Meets Moffat Bay room price requirements
INSERT INTO RoomType (room_name, room_type, nightly_rate, max_guests, availability_status) VALUES
('Double Full',  'Double Full Beds',  120.00, 2, 'available'),
('Queen Room',   'Queen',             135.00, 2, 'available'),
('Double Queen', 'Double Queen Beds', 150.00, 4, 'available'),
('King Suite',   'King',              160.00, 2, 'available');


-- Attraction

INSERT INTO Attraction (attraction_name, description, activity_type) VALUES
('Hiking',         'Scenic trails through old growth forest and coastal ridgelines',          'Hiking'),
('Kayaking',       'Guided kayak tours through calm bay waters and sea caves',                'Kayaking'),
('Salmon Fishing', 'Seasonal salmon fishing charters departing from Moffat Bay docks',         'Salmon Fishing'),
('Jet Skiing',   'Jet Skiing in the lake near Moffat Bay Lodge', 'Jet Skiing');


-- Customer

INSERT INTO Customer (first_name, last_name, email, phone, password_hash) VALUES
('James', 'Whitaker', 'james.whitaker@email.com', '555-101-2020', '$2b$10$hashedpassword1'),
('Clara', 'Moss',     'clara.moss@email.com',     '555-202-3030', '$2b$10$hashedpassword2'),
('Ethan', 'Rivers',   'ethan.rivers@email.com',   '555-303-4040', '$2b$10$hashedpassword3');


-- Reservation
-- James: Double Full x 3 nights = 360.00
-- Clara: Queen      x 4 nights = 540.00
-- Ethan: King       x 4 nights = 640.00

INSERT INTO Reservation (customer_id, room_id, check_in_date, check_out_date, total_guests, total_cost, reservation_status) VALUES
(1, 1, '2025-07-04', '2025-07-07', 2, 360.00, 'confirmed'),
(2, 2, '2025-07-10', '2025-07-14', 2, 540.00, 'pending'),
(3, 4, '2025-07-18', '2025-07-22', 2, 640.00, 'confirmed');


-- Reservation_Attraction

INSERT INTO Reservation_Attraction (reservation_id, attraction_id) VALUES
(1, 1),
(2, 2),
(3, 3);


-- Verify

SELECT * FROM Customer;
SELECT * FROM RoomType;
SELECT * FROM Attraction;
SELECT * FROM Reservation;
SELECT * FROM Reservation_Attraction;