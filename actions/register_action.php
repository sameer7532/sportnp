<?php
include_once '../utils/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if(empty($fullname) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)){
        header('Location: ../register.php?error= All fields are required');
    } else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header('Location: ../register.php?error= Invalid email');
        }
    }
 


    if($password != $confirmPassword){
        header('Location: ../register.php?error= Password and Confirm Password do not match');
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (fullname, email, phone, password) VALUES ('$fullname', '$email', '$phone', '$password')";
        if($conn->query($sql) === TRUE){
            header('Location: ../login.php');
        } else {
            header('Location: ../register.php?error= Error while registering');
        }
    }
    $conn->close();
}
