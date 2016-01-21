# Database Schema File for BoxGifts
# Author Yordan Kovachev
# Version 0.1
# Date created 26 January 2012

create database BoxGifts;
use BoxGifts;
	
	DROP TABLE IF EXISTS Customer;
	DROP TABLE IF EXISTS Address;
	DROP TABLE IF EXISTS Order;
	DROP TABLE IF EXISTS Invoice;
	DROP TABLE IF EXISTS Stock;
	DROP TABLE IF EXISTS Orders2Stock;
	DROP TABLE IF EXISTS Customer2Invoices;
	DROP TABLE IF EXISTS Invoice2Stock;


CREATE TABLE Customer (
	customerID BIGINT AUTO_INCREMENT PRIMARY KEY,
	customerFirstName VARCHAR(30),
	customerLastName VARCHAR(30),
	customerDOB DATE,
	customerAddressID VARCHAR(50) REFERENCES Address(addressID),
	customerContactNumber BIGINT,
	customerContactEmailAddress VARCHAR930)
	);


CREATE TABLE Address (
	addressID VARCHAR(50) PRIMARY KEY,
	addressNumberAndStreet VARCHAR(50),
	addressCity VARCHAR(50),
	addressCountry VARCHAR(50),
	addressPostCode VARCHAR(20)
	);


CREATE TABLE Order (
	orderNumber VARCHAR(100) PRIMARY KEY,
	orderDescription TEXT,
	orderStatus ENUM('In Process', 'Shipped', 'Delivered'),
	orderNumber BIGINT REFERENCES Customer(accountNumber)
	);


CREATE TABLE Invoice (
	invoiceNumber BIGINT AUTO_INCREMENT PRIMARY KEY,
	invoiceCustomerID FOREIGN KEY
	invoiceDateCreated DATE,
	invoiceDescription VARCHAR(150),
	invoiceTotalPrice BIGINT
	);


CREATE TABLE Product (
	productID BIGINT AUTO_INCREMENT PRIMARY KEY,
	productDateAdded DATE,
	productDescription VARCHAR(150),
	productTotalPrice BIGINT
	);


CREATE TABLE Stock (
	stockProductID VARCHAR(200) PRIMARY KEY,
	stockDateAdded DATE,
	stockProductName VARCHAR(50),
	stockProductPrice VARCHAR(100),
	stockProductType ENUM('Yes', 'No'),
	stockProductQty BIGINT
	);


CREATE TABLE Orders2Stock (
	ordersNumber VARCHAR(100) REFERENCES Orders(ordersNumber),
	stockProductID VARCHAR(200) REFERENCES Stock(stockProductID)
	);


CREATE TABLE Invoice2Stock (
	invoiceNumber BIGINT REFERENCES Invoice(invoiceNumber),
	stockParrtID VARCHAR(200) REFERENCES Stock(stockPartID)
	);	


CREATE TABLE Product2Customer (
	productID BIGINT REFERENCES Product(productID),
	customerID BIGINT REFERENCES Customer(customerID),
	customerFeedback VARCHAR(500)
	);




