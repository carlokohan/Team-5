-- =============================
--  ICS Library System Database
-- =============================
CREATE DATABASE icsls;

USE icsls;

CREATE TABLE users
(
	id INT(2) NOT NULL AUTO_INCREMENT,
	employee_number VARCHAR(9),
	student_number VARCHAR(10),
	last_name VARCHAR(32) NOT NULL,
	first_name VARCHAR(32) NOT NULL,
	middle_name VARCHAR(32),
	user_type CHAR(1) NOT NULL,
	username VARCHAR(30) NOT NULL,
	password VARCHAR(32) NOT NULL,
	college_address VARCHAR(150) NOT NULL,
	email_address VARCHAR(60) NOT NULL,
	contact_number VARCHAR(11) NOT NULL,
	borrow_limit INT(1),
	waitlist_limit INT(1),
	college VARCHAR(6),
	degree VARCHAR(12),
	PRIMARY KEY(id),
	UNIQUE KEY(employee_number,student_number)
);

CREATE TABLE reference_material
(
	id INT(11) NOT NULL AUTO_INCREMENT,
	title VARCHAR(500) NOT NULL,
	author TINYTEXT NOT NULL,
	isbn VARCHAR(13),
	category CHAR(1) NOT NULL,
	description TEXT,
	publisher VARCHAR(100),
	publication_year INT(4),
	access_type CHAR(1) NOT NULL,
	course_code VARCHAR(6) NOT NULL,
	total_available INT(2) NOT NULL,
	total_stock INT(2) NOT NULL,
	times_borrowed INT(5) DEFAULT 0,
	for_deletion CHAR(1) DEFAULT 'F',
	PRIMARY KEY(id)
);

CREATE TABLE transactions
(
	reference_material_id int(11) NOT NULL,
	borrower_id INT(11) NOT NULL,
	user_type INT(11) NOT NULL,
	waitlist_rank INT(2),
	date_waitlisted DATE,
	date_reserved DATE,
	reservation_due_date DATE,
	date_borrowed DATE,
	borrow_due_date DATE,
	date_returned DATE
);