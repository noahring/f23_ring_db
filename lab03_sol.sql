/*
    Lab 3: Tables & Fields in SQL
    CSC 362 Database Systems
    Noah Ring
*/

/* Initial design of the database */

/* Create the database */
DROP DATABASE IF EXISTS movie_ratings;

CREATE DATABASE movie_ratings;

USE movie_ratings;

/* Create the movies table */

CREATE TABLE movies (
    PRIMARY KEY (MovieID),
    MovieID                 INT,
    MovieTitle      VARCHAR(50),
    ReleaseDate     VARCHAR(10),
    Genre           VARCHAR(50)
);

/* Populate the movies table with sample data */
INSERT INTO movies (MovieID, MovieTitle, ReleaseDate, Genre)
VALUES ( '1'   , 'The Hunt for Red October'       , '1990-03-02', 'Action, Adventure, Thriller'        ),
       ( '2'   , 'Lady Bird'                      , '2017-12-01', 'Comedy, Drama'                      ),
       ( '3'   , 'Inception'                      , '2010-08-16', 'Action, Adventure, Science Fiction' ),
       ( '4'   , 'Monty Python and the Holy Grail', '1975-04-03', 'Comedy'                             );


/* Create the consumers table */
CREATE TABLE consumers (
    PRIMARY KEY (ConsumerID),
    ConsumerID          INT,
    FirstName   VARCHAR(20),
    LastName    VARCHAR(20),
    Address     VARCHAR(30),
    City        VARCHAR(20),
    State       VARCHAR(20),
    ZIPCode     VARCHAR(10)
);


/* Populate the consumers table with sample data */
INSERT INTO consumers (ConsumerID, FirstName, LastName, Address, City, State, ZIPCode)
VALUES ( '1' , 'Toru'    , 'Okada'    , '800 Glenridge Ave' , 'Hobart'     , 'IN'  , '46343' ),
       ( '2' , 'Kumiko'  , 'Okada'    , '864 NW Bohemia St' , 'Vincentown' , 'NJ'  , '08088' ),
       ( '3' , 'Noboru'  , 'Wataya'   , '342 Joy Ridge St'  , 'Hermitage'  , 'TN'  , '37076' ),
       ( '4' , 'May'     , 'Kasahara' , '5 Kent Rd'         , 'East Haven' , 'CT'  , '06512' );


/* Create the ratings table */
CREATE TABLE ratings (
    FOREIGN KEY (MovieID) REFERENCES movies(MovieID),
    FOREIGN KEY (ConsumerID) REFERENCES consumers(ConsumerID),
    MovieID      INT,
    ConsumerID   INT,
    WhenRated    VARCHAR(25),
    NumberStars  INT
);


/* Populate the ratings table with sample data */
INSERT INTO ratings (MovieID, ConsumerID, WhenRated, NumberStars)
VALUES ('1' , '1', '2010-09-02 10:54:19', '4'),
       ('1' , '3', '2012-08-05 15:00:01', '3'),
       ('1' , '4', '2016-10-02 23:58:12', '1'),
       ('2' , '3', '2017-03-27 00:12:48', '2'),
       ('2' , '4', '2018-08-02 00:54:42', '4');


/* Display the contents of the tables */
SELECT * FROM movies;
SELECT * FROM consumers;
SELECT * FROM ratings;

/* Generate a report */
SELECT FirstName, LastName, MovieTitle, NumberStars
    FROM movies
        NATURAL JOIN ratings
        NATURAL JOIN consumers;
        
/* End of initial design of the database */

/* The design flaw I found in the initial design was the repetition of movie genres. 
   This is not good practice because it creates redundancy in the database.
   To fix this, I created a new table called genres. This makes each genre a pk.
   Then made a new table called movie_genres.
   This relates the MovieID and GenreID fields from the movies and genres tables.
   This eliminates the redundancy that was in our database before. */

/* REDESIGNED TABLES */

DROP DATABASE IF EXISTS movie_ratings;

CREATE DATABASE movie_ratings;

USE movie_ratings;

/* Create the genres table */
/* Gives each genre a primary key */

CREATE TABLE genres (
    PRIMARY KEY (GenreID),
    GenreID         INT,
    Genre           VARCHAR(50)
);

/* Populate the genres table with movie genres */
INSERT INTO genres (GenreID, Genre)
VALUES ( '1'   , 'Action'          ),
       ( '2'   , 'Adventure'       ),
       ( '3'   , 'Thriller'        ),
       ( '4'   , 'Comedy'          ),
       ( '5'   , 'Drama'           ),
       ( '6'   , 'Science Fiction' );

/* Create the revised movies table */
CREATE TABLE movies (
    PRIMARY KEY (MovieID),
    MovieID                 INT,
    MovieTitle      VARCHAR(50),
    ReleaseDate     VARCHAR(10)
);

/* Populate the revised movies table with sample data */
INSERT INTO movies (MovieID, MovieTitle, ReleaseDate)
VALUES ( '1'   , 'The Hunt for Red October'       , '1990-03-02'),
       ( '2'   , 'Lady Bird'                      , '2017-12-01'),
       ( '3'   , 'Inception'                      , '2010-08-16'),
       ( '4'   , 'Monty Python and the Holy Grail', '1975-04-03');

/* Create the movie_genres table */
CREATE TABLE movie_genres (
    FOREIGN KEY (MovieID) REFERENCES movies(MovieID),
    FOREIGN KEY (GenreID) REFERENCES genres(GenreID),
    MovieID      INT,
    GenreID      INT
);

/* Populate the movie_genres table with sample data */
/* This relates each movie to its genres */
INSERT INTO movie_genres (MovieID, GenreID)
VALUES ( '1'   , '1'),
       ( '1'   , '2'),
       ( '1'   , '3'),
       ( '2'   , '4'),
       ( '2'   , '5'),
       ( '3'   , '1'),
       ( '3'   , '2'),
       ( '3'   , '6'),
       ( '4'   , '4'),
       ( '4'   , '5');

/* Create the consumers table, no revisions */
CREATE TABLE consumers (
    PRIMARY KEY (ConsumerID),
    ConsumerID          INT,
    FirstName   VARCHAR(20),
    LastName    VARCHAR(20),
    Address     VARCHAR(30),
    City        VARCHAR(20),
    State       VARCHAR(20),
    ZIPCode     VARCHAR(10)
);

/* Populate the consumers table with sample data */
INSERT INTO consumers (ConsumerID, FirstName, LastName, Address, City, State, ZIPCode)
VALUES ( '1' , 'Toru'    , 'Okada'    , '800 Glenridge Ave' , 'Hobart'     , 'IN'  , '46343' ),
       ( '2' , 'Kumiko'  , 'Okada'    , '864 NW Bohemia St' , 'Vincentown' , 'NJ'  , '08088' ),
       ( '3' , 'Noboru'  , 'Wataya'   , '342 Joy Ridge St'  , 'Hermitage'  , 'TN'  , '37076' ),
       ( '4' , 'May'     , 'Kasahara' , '5 Kent Rd'         , 'East Haven' , 'CT'  , '06512' );

/* Create the ratings table */
CREATE TABLE ratings (
    FOREIGN KEY (MovieID) REFERENCES movies(MovieID),
    FOREIGN KEY (ConsumerID) REFERENCES consumers(ConsumerID),
    MovieID              INT,
    ConsumerID           INT,
    WhenRated    VARCHAR(25),
    NumberStars          INT
);

/* Populate the ratings table with sample data */
INSERT INTO ratings (MovieID, ConsumerID, WhenRated, NumberStars)
VALUES ('1' , '1', '2010-09-02 10:54:19', '4'),
       ('1' , '3', '2012-08-05 15:00:01', '3'),
       ('1' , '4', '2016-10-02 23:58:12', '1'),
       ('2' , '3', '2017-03-27 00:12:48', '2'),
       ('2' , '4', '2018-08-02 00:54:42', '4');

/* Display the contents of the tables */
SELECT * FROM movies;
SELECT * FROM genres;
SELECT * FROM movie_genres;
SELECT * FROM consumers;
SELECT * FROM ratings;

