<?php

    class User {

        public $id, $name, $email, $employee, $phone, $pass, $image;

        function __construct($name, $email, $phone, $pass) {
            $this->name     = $name;
            $this->email    = $email;
            $this->phone    = $phone;
            $this->pass     = $pass;
        }

        public function setImage($image) {
            $this->image = $image;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setName($name) {
            $this->name = $name;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function setEmployee($employee) {
            $this->employee = $employee;
        }

        public function setPhone($phone) {
            $this->phone = $phone;
        }

        public function setPass($pass) {
            $this->pass = $pass;
        }

    }
    