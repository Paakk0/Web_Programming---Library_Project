<?php

    class Handler {

        private $dbName, $conn, $result;

        public function __construct() {
            $this->dbName = "LibraryDB";
            $this->conn   = mysqli_connect('localhost', 'root', '');
        }

        public function initializeDB() {
            if (!mysqli_select_db($this->conn, $this->dbName)) {
                $sql          = 'CREATE DATABASE ' . $this->dbName;
                $this->result = mysqli_query($this->conn, $sql) or die('Could not create database: ' . mysqli_error($this->conn));
                $this->result = mysqli_select_db($this->conn, $this->dbName) or die('Could not select database: ' . mysqli_error($this->conn));
                $this->result = mysqli_query($this->conn, $this->ini_TableBooks()) or die('Could not create table: ' . mysqli_error($this->conn));
                $this->result = mysqli_query($this->conn, $this->ini_TableUsers()) or die('Could not create table: ' . mysqli_error($this->conn));
                $this->result = mysqli_query($this->conn, $this->ini_TableBorrowed_Books()) or die('Could not create table: ' . mysqli_error($this->conn));
                $this->result = mysqli_query($this->conn, $this->fillBooks()) or die('Could not insert data into table: ' . mysqli_error($this->conn));
            }
        }

        public function restartDB() {
            $sql          = 'DROP DATABASE ' . $this->dbName;
            $this->result = mysqli_query($this->conn, $sql) or die('Could not drop database: ' . mysqli_error($this->conn));
        }

        public function getConnection() {
            return $this->conn;
        }

        private final function ini_TableBooks() {
            return 'CREATE TABLE BOOKS('
                    . 'ID_BOOK              INTEGER         NOT NULL PRIMARY KEY,'
                    . 'TITLE                VARCHAR(4000)   NOT NULL,'
                    . 'PAGES                INTEGER         NOT NULL,'
                    . 'IMAGE                VARCHAR(4000) NOT NULL,'
                    . 'PRICE                DECIMAL(9,2)    NOT NULL,'
                    . 'AVAILABLE_PIECES     INT             NOT NULL)';
        }

        private final function ini_TableUsers() {
            return 'CREATE TABLE USERS('
                    . 'ID_USER              INTEGER         NOT NULL PRIMARY KEY,'
                    . 'NAME                 VARCHAR(4000)   NOT NULL,'
                    . 'IS_EMPLOYEE          INTEGER         NOT NULL,'
                    . 'EMAIL                VARCHAR(4000)   NOT NULL,'
                    . 'PHONE                CHAR(10)        NOT NULL,'
                    . 'PASSWORD             CHAR(255)       NOT NULL)';
        }

        private final function ini_TableBorrowed_Books() {
            return 'CREATE TABLE BOOKS_BORROWED('
                    . 'ID_USER              INTEGER,'
                    . 'ID_BOOK              INTEGER,'
                    . 'STATUS               INTEGER,'//TRUE=BOUGHT | FLASE=BORROWED
                    . 'START_DATE           DATE,'
                    . 'END_DATE             DATE,'
                    . 'CONSTRAINT `FK_ID_USER` FOREIGN KEY (ID_USER) REFERENCES USERS (ID_USER),'
                    . 'CONSTRAINT `FK_ID_BOOK` FOREIGN KEY (ID_BOOK) REFERENCES BOOKS (ID_BOOK))';
        }

        private final function fillBooks() {
            return "INSERT INTO librarydb.books VALUES 
                (1, 'To Kill a Mockingbird', 336, '../Images/ToKillAMockingBird.jpg', 7.99, 100),
                (2, 'Avatar', 328, '../Images/Avatar.jpg', 6.99, 80),
                (3, 'The Alchemist', 208, '../Images/TheAlcemist.jpg', 9.99, 120),
                (4, 'Harry Potter and the Sorcerer\'s Stone', 309, '../Images/HarryPotter.jpg', 9.99, 150),
                (5, 'The Hobbit', 310, '../Images/TheHobbit.jpg', 10.99, 75),
                (6, 'Life of Pi', 336, '../Images/LifeOfPi.jpg', 7.89, 65),
                (7, 'The Catcher in the Rye', 277, '../Images/TheCatcherInTheRye.jpg', 9.99, 100),
                (8, 'The Great Gatsby', 180, '../Images/TheGreatGatsby.jpg', 10.99, 50),
                (9, 'Fahrenheit 451', 194, '../Images/F451.jpg', 7.49, 60),
                (10, 'Brave New World', 311, '../Images/BraveNewWorld.jpg', 8.99, 45),
                (11, 'The Lord of the Rings', 1178, '../Images/Rings.jpg', 15.99, 30),
                (12, 'The Handmaid\'s Tale', 311, '../Images/TheHandmaidsTale.jpg', 12.99, 55),
                (13, 'The Book Thief', 552, '../Images/TheBookThief.jpg', 11.99, 40);";
        }

    }
    