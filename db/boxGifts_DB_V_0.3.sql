# Database Schema File for BoxGifts
# Author Yordan Kovachev
# Version 0.3
# Date created 26 January 2012
/*
This database file describes the layout and structure of the MySQL 5 database for BoxGifts
*/

# First we create the database and perform some table checks and insert the necesssary tables as required

drop database boxGifts;
CREATE DATABASE boxGifts;
USE boxGifts;

# First remove all tables if any

DROP TABLE IF EXISTS addresses;
DROP TABLE IF EXISTS countries2users;
DROP TABLE IF EXISTS discounts;
DROP TABLE IF EXISTS discounts2products;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS images2products;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS orders2users;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

# STRUCTURE FOR TABLE products

CREATE TABLE products(
	productID BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	productName VARCHAR(255) NOT NULL,
	productDescription TEXT,
	productPrice FLOAT NOT NULL
	);

# STRUCTURE FOR TABLE images

CREATE TABLE images(
	imageID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	imageName VARCHAR(100),
	imageWidth SMALLINT,
	imageHeight SMALLINT,
	imageLocation VARCHAR(255)
	);

# STRUCTURE FOR TABLE images2Products

CREATE TABLE images2Products(
	imageID SMALLINT REFERENCES images(imageID),
	productID BIGINT REFERENCES products(productID)
	);

# STRUCTURE FOR TABLE discounts

CREATE TABLE discounts(
	discountID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	discount SMALLINT
	);

# STRUCTURE FOR TABLE discounts2products

CREATE TABLE discounts2Products(
	productID BIGINT REFERENCES products(productID),
	discountID SMALLINT REFERENCES discounts(discountID)
	);

# STRUCTURE FOR TABLE users

CREATE TABLE users(
	userID BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	firstName VARCHAR(255),
	lastName VARCHAR(255),
	DOB DATE,
	phone SMALLINT,
	email VARCHAR(255),
	userAvatar VARCHAR(255),
	userType ENUM('admin', 'customer', 'staff')
	);

# STRUCTURE FOR TABLE addresses

CREATE TABLE addresses(
	addressID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	addressName VARCHAR(100),
	addressLine1 VARCHAR(255),
	addressLine2 VARCHAR(255),
	postCode VARCHAR(30),
	city VARCHAR(255),
	country VARCHAR(100)
	);

# STRUCTURE FOR TABLE users2addresses

CREATE TABLE users2addresses(
userID BIGINT REFERENCES users(userID),
	addressID SMALLINT REFERENCES addresses(addressID)
	);

# STRUCTURE FOR TABLE ORDERS

CREATE TABLE orders(
	orderNumber SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	orderStatus ENUM('In Process', 'Shipped', 'Delivered'),
	orderNote TEXT
	);

# STRUCTURE FOR TABLE orders2users

CREATE TABLE orders2users(
	orderNumber SMALLINT REFERENCES orders(orderNumber),
	userID BIGINT REFERENCES users(userID)
	);
# SAMPLE DATA FOR TABLE products

INSERT INTO products (productName, productDescription, productPrice) VALUES ('Boy LITTLE STAR', 'Beautiful handmade blue keepsake box with integrated photo frame,
Star hat and booties, Soft blue fleece blanket, key style teething ring.', 12.95);
INSERT INTO products (productName, productDescription, productPrice) VALUES ('Girl LITTLE STAR', 'This set comes complete with - Beautiful handmade pink keepsake box with integrated photo frame,
Star hat and booties, Soft pink fleece blanket, key style teething ring.', 12.95);