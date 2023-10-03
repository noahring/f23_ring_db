/*
    Lab 5: Implementing a Database
    CSC 362 Database Systems
    Noah Ring
*/

/* Create the database */
DROP DATABASE IF EXISTS RugGallery;

CREATE DATABASE RugGallery;

USE RugGallery;

/* Creating country table */
CREATE TABLE RugCountry (
    PRIMARY KEY (rug_country),
    rug_country      VARCHAR(32)
);

/* Create styles table */
CREATE TABLE RugStyles (
    PRIMARY KEY (rug_style),
    rug_style        VARCHAR(20)
);

/* Create material table */
CREATE TABLE RugMaterial (
    PRIMARY KEY (rug_material),
    rug_material     VARCHAR(20)
);

/* Create rug table */
CREATE TABLE Rugs (
    PRIMARY KEY (rug_id),
    rug_id           INT AUTO_INCREMENT,
    rug_country      VARCHAR(32),
    rug_style        VARCHAR(20),
    rug_material     VARCHAR(20), 
    rug_year_made    INT NOT NULL,
    rug_purch_price  INT NOT NULL,
    rug_markup       INT NOT NULL,
    rug_length       INT NOT NULL,
    rug_width        INT NOT NULL,
    FOREIGN KEY (rug_country)  REFERENCES RugCountry(rug_country),
    FOREIGN KEY (rug_style)    REFERENCES RugStyles(rug_style),
    FOREIGN KEY (rug_material) REFERENCES RugMaterial(rug_material)
);

/* Creating customer table */
CREATE TABLE Customers (
    PRIMARY KEY (customer_id),
    customer_id        INT AUTO_INCREMENT,
    customer_name      VARCHAR(32) NOT NULL,
    customer_address   VARCHAR(32) NOT NULL,
    customer_city      VARCHAR(32) NOT NULL,
    customer_state     VARCHAR(32) NOT NULL,
    customer_zip       VARCHAR(32) NOT NULL,
    customer_phone     VARCHAR(32) NOT NULL UNIQUE
);

/* Creating trials table */
CREATE TABLE Trials (
    rug_id            INT,
    customer_id       INT,
    trial_start_date  datetime DEFAULT NULL,
    trial_end_date    datetime DEFAULT NULL,
    rug_return_date   datetime DEFAULT NULL,
    FOREIGN KEY (rug_id)      REFERENCES Rugs(rug_id),
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
    CHECK (trial_end_date > trial_start_date)
);

/* Creating purchases table */
CREATE TABLE Purchases (
    rug_id                INT,
    customer_id           INT,
    purchase_date         datetime NOT NULL,
    purchase_return_date  datetime DEFAULT NULL,
    FOREIGN KEY (rug_id)      REFERENCES Rugs(rug_id),
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
    CHECK (purchase_return_date > purchase_date)
);

/* Deletion rule for rugs */
CREATE VIEW deletable_rugs AS
    SELECT rug_id, rug_country, rug_style, rug_material, rug_year_made, rug_purch_price, rug_markup, rug_length, rug_width
    FROM Rugs
    WHERE rug_id NOT IN (SELECT rug_id FROM Purchases)
    AND rug_id NOT IN (SELECT rug_id FROM Trials);


