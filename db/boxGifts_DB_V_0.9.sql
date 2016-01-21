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
DROP TABLE IF EXISTS countries2users;
DROP TABLE IF EXISTS discounts;
DROP TABLE IF EXISTS discounts2Products;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS images2Products;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS orders2users;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS users2addresses;
DROP TABLE IF EXISTS transactions;

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
/*Note that the information for each Customer will be used and stored in the table transactions (e.g. fname, lname, email etc.) Avoid indexing of varchars colomns of 255 long */

CREATE TABLE users(
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
    firstName VARCHAR(20),
    lastName VARCHAR(20),
    DOB DATE,
    gender ENUM('m', 'f'),
    phone BIGINT,
    email VARCHAR(200),
	username VARCHAR(200),
    password VARCHAR (255),
    userAvatar VARCHAR(50),
    INDEX (email, firstName, lastName)
    );

# STRUCTURE FOR TABLE admin
	
CREATE TABLE admin(
	id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE KEY,
	username VARCHAR(100),
	password VARCHAR(100),
	loginDate DATE,
	adminType ENUM('admin', 'manager', 'staff')
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
	INDEX (transactionID)
    );




/*DB Statements*/

# SAMPLE DATA FOR TABLE products

INSERT INTO products (productName, productDescription, productPrice) VALUES ('Boy LITTLE STAR', 'Beautiful handmade blue keepsake box with integrated photo frame,
Star hat and booties, Soft blue fleece blanket, key style teething ring.', 12.95);
INSERT INTO products (productName, productDescription, productPrice) VALUES ('Girl LITTLE STAR', 'This set comes complete with - Beautiful handmade pink keepsake box with integrated photo frame,
Star hat and booties, Soft pink fleece blanket, key style teething ring.', 12.95);

# SAMPLE DATA FOR TABLE users

INSERT INTO users (firstName, lastName, DOB, phone, email, username, password) VALUES ('Johnathan', 'Swiftt', '1994/04/27', '07727456233', 'customer01@gmail.com', 'customer01@gmail.com', 'customer01');
INSERT INTO users (firstName, lastName, DOB, phone, email, username, password) VALUES ('Martin', 'Wellss', '2005/03/11', '07727212233', 'customer02@gmail.com', 'customer02@gmail.com', 'customer02');


# SAMPLE DATA FOR TABLE admin

INSERT INTO admin (username, password, loginDate, adminType) VALUES ('Yordan', 'admin', '2005/04/03', 'admin');
INSERT INTO admin (username, password, loginDate, adminType) VALUES ('Tina', 'staff', '2012/01/11', 'staff');
INSERT INTO admin (username, password, loginDate, adminType) VALUES ('Stuart', 'manager', '2012/02/11', 'manager');

















