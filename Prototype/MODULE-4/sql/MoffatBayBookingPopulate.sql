USE MoffatBayBooking;

DELETE FROM Reservation_Attraction;
DELETE FROM Reservation;
DELETE FROM Attraction;
DELETE FROM RoomType;
DELETE FROM Customer;

ALTER TABLE Reservation_Attraction AUTO_INCREMENT = 1;
ALTER TABLE Reservation AUTO_INCREMENT = 1;
ALTER TABLE Attraction AUTO_INCREMENT = 1;
ALTER TABLE RoomType AUTO_INCREMENT = 1;
ALTER TABLE Customer AUTO_INCREMENT = 1;

INSERT INTO Customer (first_name, last_name, email, phone, password_hash) VALUES
('James', 'Whitaker', 'james.whitaker@email.com', '555-101-2020', 'hashedpassword1'),
('Clara', 'Moss',     'clara.moss@email.com',     '555-202-3030', 'hashedpassword2'),
('Ethan', 'Rivers',   'ethan.rivers@email.com',   '555-303-4040', 'hashedpassword3');

INSERT INTO RoomType (room_name, room_type, nightly_rate, max_guests, availability_status) VALUES
('Redwood Ridge Room', 'Lodge Room', 189.99, 2, 'available'),
('Cedar Creek Cabin',  'Cabin',      249.99, 4, 'available'),
('Sagebrush Suite',    'Suite',      329.99, 6, 'available');

INSERT INTO Attraction (attraction_name, description, activity_type) VALUES
('Guided Nature Walk',    'Explore forest trails through ancient redwoods and mossy creeks',  'Hiking'),
('Riverside Fly Fishing', 'Cast along the quiet river bends with a seasoned local guide',     'Fishing'),
('Campfire Stargazing',   'Evening fire pit session with telescope viewing of the night sky', 'Stargazing');

INSERT INTO Reservation (customer_id, room_id, check_in_date, check_out_date, total_guests, reservation_status) VALUES
(1, 1, '2025-07-04', '2025-07-07', 2, 'confirmed'),
(2, 2, '2025-07-10', '2025-07-14', 4, 'pending'),
(3, 3, '2025-07-18', '2025-07-22', 6, 'confirmed');

INSERT INTO Reservation_Attraction (reservation_id, attraction_id) VALUES
(1, 1),
(2, 2),
(3, 3);