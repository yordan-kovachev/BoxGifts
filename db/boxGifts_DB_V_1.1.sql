# Database Schema File for BoxGifts
# Author Yordan Kovachev
# Version 0.9
# Date created 26 January 2012
/*
This database file describes the layout and structure of the MySQL 5 database for BoxGifts
*/

# First we create the database and perform some table checks and insert the necesssary tables as required

/*drop database boxGifts;
CREATE DATABASE boxGifts;
USE boxGifts;*/

# First remove all tables if any

DROP TABLE IF EXISTS addresses;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS customers2Addresses;
DROP TABLE IF EXISTS discounts;
DROP TABLE IF EXISTS discounts2Products;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS images2Products;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS orders2Customers;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS transactions;

# STRUCTURE FOR TABLE addresses

CREATE TABLE addresses(
    id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
    addressLine1 VARCHAR(255),
    addressLine2 VARCHAR(255),
    postCode VARCHAR(30),
    city VARCHAR(255),
    country VARCHAR(100)
    );

# STRUCTURE FOR TABLE admin

CREATE TABLE admin(
	id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
	username VARCHAR(100),
	password VARCHAR(100),
	loginDate DATE,
	adminType ENUM('admin', 'manager', 'staff')
	);

# STRUCTURE FOR TABLE users
/*Note that the information for each Customer will be used and stored in the table transactions (e.g. fname, lname, email etc.) Avoid indexing of varchars colomns of 255 long */

CREATE TABLE customers(
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
    firstName VARCHAR(20),
    lastName VARCHAR(20),
    DOB DATE,
    gender ENUM('male', 'female'),
    phone BIGINT,
    email VARCHAR(200),
	username VARCHAR(200),
    password VARCHAR (255),
    INDEX (email, firstName, lastName)
    );

# STRUCTURE FOR TABLE users2addresses

CREATE TABLE customers2Addresses(
    customerID BIGINT REFERENCES customers(id),
    addressID SMALLINT REFERENCES addresses(id)
    );


# STRUCTURE FOR TABLE discounts

CREATE TABLE discounts(
    id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
    discount SMALLINT
    );

# STRUCTURE FOR TABLE discounts2products

CREATE TABLE discounts2Products(
    productID BIGINT REFERENCES products(id),
	discountID SMALLINT REFERENCES discounts(id)
	    );

# STRUCTURE FOR TABLE images

CREATE TABLE images(
    id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    imageName VARCHAR(100),
    imageLocation VARCHAR(255)
    );

# STRUCTURE FOR TABLE images2Products

CREATE TABLE images2Products(
    imageID SMALLINT REFERENCES images(id),
    productID BIGINT REFERENCES products(id)
    );

# STRUCTURE FOR TABLE ORDERS

CREATE TABLE orders(
    id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
    orderStatus ENUM('In Process', 'Shipped', 'Delivered'),
    orderNote TEXT
    );

# STRUCTURE FOR TABLE orders2Customers

CREATE TABLE orders2Customers(
    orderID SMALLINT REFERENCES orders(id),
    customerID BIGINT REFERENCES customers(id)
    );

# STRUCTURE FOR TABLE products

CREATE TABLE products(
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    productName VARCHAR(255) NOT NULL UNIQUE KEY,
	productPrice FLOAT NOT NULL,
    productCategory VARCHAR(100) NOT NULL,
	productSubcategory VARCHAR(100) NOT NULL,
    productDescription TEXT,
    productQuantity BIGINT NOT NULL,
    productDateAdded DATE NOT NULL,
    INDEX (id, productName)
    );


/*DB Statements*/

# SAMPLE DATA FOR TABLE products

INSERT INTO products (productName, productPrice, productCategory, productSubcategory, productDescription, productQuantity) VALUES ('Boy LITTLE STAR', 12.95, 'Boy', 'Box Sets', 'Beautiful handmade blue keepsake box with integrated photo frame,
Star hat and booties, Soft blue fleece blanket, key style teething ring.', 1);
INSERT INTO products (productName, productPrice, productCategory, productSubcategory, productDescription, productQuantity) VALUES ('Girl LITTLE STAR', 12.95, 'Girl', 'Box Sets', 'This set comes complete with - Beautiful handmade pink keepsake box with integrated photo frame, Star hat and booties, Soft pink fleece blanket, key style teething ring.', 2);
INSERT INTO products (productName, productPrice, productCategory, productSubcategory, productDescription, productQuantity) VALUES ('Neutral', 12.95, 'Twins', 'Box Sets', 'This set comes complete with - Beautiful handmade pink keepsake box with integrated photo frame, Star hat and booties, Soft pink fleece blanket, key style teething ring.', 2);

# SAMPLE DATA FOR TABLE customers

INSERT INTO customers (firstName, lastName, DOB, phone, email, username, password) VALUES ('Johnathan', 'Swiftt', '1994/04/27', '07727456233', 'customer01@gmail.com', 'customer01@gmail.com', 'customer01');
INSERT INTO customers (firstName, lastName, DOB, phone, email, username, password) VALUES ('Martin', 'Wellss', '2005/03/11', '07727212233', 'customer02@gmail.com', 'customer02@gmail.com', 'customer02');


# SAMPLE DATA FOR TABLE admin

INSERT INTO admin (username, password, loginDate, adminType) VALUES ('Yordan', 'admin', '2005/04/03', 'admin');
INSERT INTO admin (username, password, loginDate, adminType) VALUES ('Tina', 'staff', '2012/01/11', 'staff');
INSERT INTO admin (username, password, loginDate, adminType) VALUES ('Stuart', 'manager', '2012/02/11', 'manager');