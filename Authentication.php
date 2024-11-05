<?php

    include_once '../Database/UserOperations.php';

    session_start();

    function signIn($name, $email, $phone, $pass) {
        if (checkAllFields($name, $email, $phone, $pass) && checkEmail($email) && checkPhone($phone) && checkPassword($pass)) {
            return true;
        }
    }

    function checkSignUp($name, $email, $phone, $pass) {
        return checkAllFields($name, $email, $phone, $pass) && checkEmail($email) && checkPhone($phone) && checkPassword($pass);
    }

    function checkAllFields($name, $email, $phone, $pass) {
        if ($name != NULL && $email != NULL && $phone != NULL && $pass != NULL) {
            return true;
        }
        echo "<script type='text/javascript'>alert('Please fill all fields!');</script>";
        return false;
    }

    function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        echo "<script type='text/javascript'>alert('Email is not valid!');</script>";
        return false;
    }

    function checkPhone($phone) {
        if (preg_match('/^[0-9]{10}$/', $phone)) {
            return true;
        }
        echo "<script type='text/javascript'>alert('Phone number must be 10 digits!');</script>";
        return false;
    }

    function checkPassword($pass) {
        if (strlen($pass) >= 8) {
            return true;
        }
        echo "<script type='text/javascript'>alert('Password must be atleast 8 characters!');</script>";
        return false;
    }

    function login($email, $password) {
        $user = findUser($email, $password);
        if ($user) {
            $_SESSION['user_id']          = $user->id;
            $_SESSION['user_name']        = $user->name;
            $_SESSION['user_image']       = $user->image;
            $_SESSION['user_email']       = $user->email;
            $_SESSION['user_is_employee'] = $user->employee;
            $_SESSION['user_phone']       = $user->phone;
            $_SESSION['user_password']    = $user->pass;
            return true;
        }
        else {
            return false;
        }
    }

    function logout() {
        session_unset();
        session_destroy();
    }

    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    function getUserInfo() {
        return [
            'id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null,
            'name' => isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null,
            'image' => isset($_SESSION['user_image']) ? $_SESSION['user_image'] : null,
            'email' => isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null,
            'phone' => isset($_SESSION['user_phone']) ? $_SESSION['user_phone'] : null,
            'employee' => isset($_SESSION['user_is_employee']) ? $_SESSION['user_is_employee'] : null,
            'password' => isset($_SESSION['user_password']) ? $_SESSION['user_password'] : null
        ];
    }
    