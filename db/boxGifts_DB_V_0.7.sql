# Database Schema File for BoxGifts
# Author Yordan Kovachev
# Version 0.7
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
DROP TABLE IF EXISTS users2addresses;
DROP TABLE IF EXISTS transactions;

# STRUCTURE FOR TABLE products

CREATE TABLE products(
    productID BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
    productName VARCHAR(255) NOT NULL UNIQUE KEY,
    productDescription TEXT,
    productPrice FLOAT NOT NULL,
    productQuantity INT(5) NOT NULL,
    productCategory VARCHAR(100) NOT NULL,
    productAdded DATE NOT NULL,
    INDEX (productName)
    );

# STRUCTURE FOR TABLE images

CREATE TABLE images(
    imageID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    imageName VARCHAR(100),
    imageLocation VARCHAR(255)
    );

# STRUCTURE FOR TABLE images2Products

CREATE TABLE images2Products(
    imageID SMALLINT REFERENCES images(imageID),
    productID BIGINT REFERENCES products(productID)
    );

# STRUCTURE FOR TABLE discounts

CREATE TABLE discounts(
    discountID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
    discount SMALLINT
    );

# STRUCTURE FOR TABLE discounts2products

CREATE TABLE discounts2Products(
    productID BIGINT REFERENCES products(productID),
    discountID SMALLINT REFERENCES discounts(discountID)
    );

# STRUCTURE FOR TABLE users
/*Note that the information for each Customer will be used and stored in the table transactions (e.g. fname, lname, email etc.)*/

CREATE TABLE users(
    userID BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    DOB DATE,
    gender ENUM('m', 'f'),
    phone BIGINT,
    email VARCHAR(255) UNIQUE KEY,
    password VARCHAR (255),
    userAvatar VARCHAR(255),
    userType ENUM('admin', 'staff', 'customer'),
    INDEX (email, firstName, lastName)
    );

# STRUCTURE FOR TABLE addresses

CREATE TABLE addresses(
    addressID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
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
    orderNumber SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
    orderStatus ENUM('In Process', 'Shipped', 'Delivered'),
    orderNote TEXT
    );

# STRUCTURE FOR TABLE orders2users

CREATE TABLE orders2users(
    orderNumber SMALLINT REFERENCES orders(orderNumber),
    userID BIGINT REFERENCES users(userID)
    );
    

#STRUCTURE FOR TABLE transactions
/*Most of the fields will be set to VARCHAR property input in order to remove the restriction in terms of storing the data passed from PayPal payments and transactions*/

CREATE TABLE transactions(
	transactionID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	productIDarray VARCHAR (255) NOT NULL,
	payerEmail VARCHAR (255) NOT Null,
	payerStatus VARCHAR (255) NOT Null,
	firstName VARCHAR (255) NOT Null,
	lastName VARCHAR (255) NOT Null,
	paymentDate VARCHAR (255) NOT Null,
	merchantGross VARCHAR (255) NOT Null,
	paymentCurrency VARCHAR (255) NOT Null,
	taxNumberID VARCHAR (255) NOT Null UNIQUE KEY,
	taxType VARCHAR (255) NOT Null,
	receiverEmail VARCHAR (255) NOT Null,
	paymentType VARCHAR (255) NOT Null,
	paymentStatus VARCHAR (255) NOT Null,
	addressStreet VARCHAR (255) NOT Null,
	addressCity VARCHAR (255) NOT Null,
	addressTown VARCHAR (255) NOT Null,
	addressPosrtCode VARCHAR (255) NOT Null,
	addressCountry VARCHAR (255) NOT Null,
	addressStatus VARCHAR (255) NOT Null,
	notifyVersion VARCHAR (255) NOT Null,
	verifySign VARCHAR (255) NOT Null,
	playerID VARCHAR (255) NOT Null,
	merchantCurrency VARCHAR (255) NOT Null,
	merchantFee VARCHAR (255) NOT Null,
	INDEX (transactionID, taxNumberID)
    );




/*DBSL Statements - INSERT, SELECT, DELETE, UPDATE */

# SAMPLE DATA FOR TABLE products

INSERT INTO products (productID, productName, productDescription, productPrice) VALUES ('01', 'Boy LITTLE STAR', 'Beautiful handmade blue keepsake box with integrated photo frame,
Star hat and booties, Soft blue fleece blanket, key style teething ring.', 12.95);
INSERT INTO products (productID, productName, productDescription, productPrice) VALUES ('02','Girl LITTLE STAR', 'This set comes complete with - Beautiful handmade pink keepsake box with integrated photo frame,
Star hat and booties, Soft pink fleece blanket, key style teething ring.', 12.95);

# SAMPLE DATA FOR TABLE users

INSERT INTO users (userID, firstName, lastName, DOB, phone, email, password, userType) VALUES ('00', 'Yordan', 'Kovachev', '1981/01/01', '07727222233', 'admin00@gmail.com', 'admin00','admin');
INSERT INTO users (userID, firstName, lastName, DOB, phone, email, password, userType) VALUES ('01', 'Johnathan', 'Swiftt', '1994/04/27', '07727456233', 'customer01@gmail.com','customer01', 'customer');
INSERT INTO users (userID, firstName, lastName, DOB, phone, email,password, userType) VALUES ('02', 'Martin', 'Wellss', '2005/03/11', '07727212233', 'customer02@gmail.com', 'customer02','customer');
INSERT INTO users (userID, firstName, lastName, DOB, phone, email, password, userType) VALUES ('03', 'Michael', 'Smith', '2001/05/23', '077272452233', 'staff01@gmail.com', 'staff01', 'staff');


