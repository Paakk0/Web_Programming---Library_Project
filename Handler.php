<?php

    class Handler {

        private $dbName, $conn, $result;

        public function __construct() {
            $this->dbName = "LibraryDB";
            $this->conn   = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($this->conn, $this->dbName);
        }

        public function initializeDB() {
            if (!mysqli_select_db($this->conn, $this->dbName)) {
                $sql          = 'CREATE DATABASE ' . $this->dbName;
                $this->result = mysqli_query($this->conn, $sql) or die('Could not create database: ' . mysqli_error($this->conn));
                $this->result = mysqli_select_db($this->conn, $this->dbName) or die('Could not select database: ' . mysqli_error($this->conn));
                $this->result = mysqli_query($this->conn, $this->ini_TableBooks()) or die('Could not create table: ' . mysqli_error($this->conn));
                $this->result = mysqli_query($this->conn, $this->ini_TableUsers()) or die('Could not create table: ' . mysqli_error($this->conn));
                $this->result = mysqli_query($this->conn, $this->ini_TableInventory()) or die('Could not create table: ' . mysqli_error($this->conn));
                $this->result = mysqli_query($this->conn, $this->fillBooks()) or die('Could not insert data into tabl   e: ' . mysqli_error($this->conn));
                $this->result = mysqli_query($this->conn, $this->addAdmin()) or die('Could not add default administrator: ' . mysqli_error($this->conn));
            }
        }

        public function restartDB() {
            $sql          = 'DROP DATABASE ' . $this->dbName;
            $this->result = mysqli_query($this->conn, $sql) or die('Could not drop database: ' . mysqli_error($this->conn));
        }

        public function getConnection() {
            return $this->conn;
        }

        function getTableColumnId($table) {
            switch (strtoupper($table)) {
                case 'BOOKS':
                    return 'ID_BOOK';
                case 'USERS':
                    return 'ID_USER';
                case 'INVENTORY':
                    return 'ID_ROW';
            }
        }

        public function updateRecord($table, $id, $data) {
            $idColumn = $this->getTableColumnId($table);

            $setClauses = [];
            foreach ($data as $column => $value) {
                $safeValue    = mysqli_real_escape_string($this->conn, $value);
                $setClauses[] = "`$column` = '$safeValue'";
            }
            $setClause = implode(', ', $setClauses);
            $sql       = "UPDATE `$table` SET $setClause WHERE `$idColumn` = $id";
            $result    = mysqli_query($this->conn, $sql) or die('Error updating record: ' . mysqli_error($this->conn));
            return $result;
        }

        public function deleteRecord($table, $idColumn, $id) {
            $sql      = "DELETE FROM $table WHERE $idColumn = $id";
            $result   = mysqli_query($this->conn, $sql) or die("Could not remove user from table: " . mysqli_error($this->conn));
            return $result;
        }

        function getData($table) {
            $sql    = 'SELECT * FROM ' . $table;
            $result = mysqli_query($this->conn, $sql) or die('Could not get data: ' . mysqli_error($this->conn));
            return $result;
        }

        private final function ini_TableBooks() {
            return 'CREATE TABLE BOOKS('
                    . 'ID_BOOK              INTEGER         NOT NULL PRIMARY KEY AUTO_INCREMENT,'
                    . 'TITLE                VARCHAR(4000)   NOT NULL,'
                    . 'PAGES                INTEGER         NOT NULL,'
                    . 'IMAGE                VARCHAR(4000)   NOT NULL,'
                    . 'PRICE                DECIMAL(9,2)    NOT NULL,'
                    . 'AVAILABLE_PIECES     INT             NOT NULL)';
        }

        private final function ini_TableUsers() {
            return 'CREATE TABLE USERS('
                    . 'ID_USER              INTEGER         NOT NULL PRIMARY KEY AUTO_INCREMENT,'
                    . 'NAME                 VARCHAR(4000)   NOT NULL,'
                    . 'PROFILE_IMAGE        VARCHAR(4000)   NOT NULL,'
                    . 'IS_EMPLOYEE          INTEGER         NOT NULL,'
                    . 'EMAIL                VARCHAR(4000)   NOT NULL,'
                    . 'PHONE                CHAR(10)        NOT NULL,'
                    . 'PASSWORD             CHAR(255)       NOT NULL)';
        }

        private final function ini_TableInventory() {
            return 'CREATE TABLE INVENTORY('
                    . 'ID_ROW               INTEGER         NOT NULL PRIMARY KEY AUTO_INCREMENT,'
                    . 'ID_USER              INTEGER         NOT NULL,'
                    . 'ID_BOOK              INTEGER         NOT NULL,'
                    . 'STATUS               INTEGER         NOT NULL,'
                    . 'TYPE                 INTEGER         NOT NULL,'
                    . 'START_DATE           DATE            NOT NULL,'
                    . 'END_DATE             DATE,'
                    . 'CONSTRAINT `FK_ID_USER` FOREIGN KEY (ID_USER) REFERENCES USERS (ID_USER) ON DELETE CASCADE,'
                    . 'CONSTRAINT `FK_ID_BOOK` FOREIGN KEY (ID_BOOK) REFERENCES BOOKS (ID_BOOK) ON DELETE CASCADE)';
        }

        private final function addAdmin() {
            return "INSERT INTO librarydb.users VALUES 
                (1,'Hristiyan Kerkenezov','../Images/default_user_image.png',1,'beko1972@abv.bg','0987654321','1');";
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
                (13, 'The Book Thief', 552, '../Images/TheBookThief.jpg', 11.99, 40),
                (14, 'Batman: Year One', 144, '../Images/Batman.jpg', 14.99, 50),
                (15, 'The Road', 287, '../Images/TheRoad.webp', 9.49, 60),
                (16, 'Assassin\'s Creed: Renaissance', 528, '../Images/AssassinsCreed.jpg', 12.99, 75);";
        }

    }
    