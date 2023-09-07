/*
    Lab 2: MariaDB Tutorial
    CSC 362 Database Systems
    Noah Ring
*/

/* Create the database */

DROP DATABASE IF EXISTS school;

CREATE DATABASE school;

USE school;

/* Creating instructors table */

CREATE TABLE instructors (
    PRIMARY KEY (instructor_id),
    instructor_id      INT AUTO_INCREMENT,
    instfirst_name    VARCHAR(20),
    instlast_name     VARCHAR(20),
    campus_phone       VARCHAR(20)
);

/* Populate the instructors table with sample data */
INSERT INTO instructors (instfirst_name, instlast_name, campus_phone)
VALUES ( 'Kira'   , 'Bentley', '363-9948' ),
       ( 'Timothy', 'Ennis'  , '527-4992' ),
       ( 'Shannon', 'Black'  , '336-5992' ),
       ( 'Estela' , 'Rosales', '322-6992' );

/* Displays all data in the table. */

SELECT * FROM instructors

/* End of file lab02b.sql */