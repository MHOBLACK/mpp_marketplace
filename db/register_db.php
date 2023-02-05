<?php
    session_start();
    include('server.php');

    $error = array();

    if (isset($_POST['register-user'])) {

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password_confirm = mysqli_real_escape_string($conn, $_POST['password-confirm']);

        if ($password != $password_confirm) {
            array_push($error, "รหัสผ่านไม่ตรงกัน");
            $_SESSION['error'] = "รหัสผ่านไม่ตรงกัน";
        }

        $user_check = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
        $user_check_query = mysqli_query($conn, $user_check);
        $user_check_result = mysqli_fetch_assoc($user_check_query);

        if ($user_check_result) {
            if ($user_check_result['username'] === $username) {
                array_push($error, "มีชื่อผู้ใช้นี้อยู่ในระบบแล้ว กรุณาหาชื่อใหม่");
                $_SESSION['error'] = "มีชื่อผู้ใช้นี้อยู่ในระบบแล้ว กรุณาหาชื่อใหม่";
            }
        }

        if (count($error) == 0) {
            // นำ "//" ออก หากต้องการให้มีการเข้ารหัส
            // $password = md5($password); 
            
            $insert_user = "INSERT INTO user (username, password, role) VALUES ('$username', '$password', 'member')";
            mysqli_query($conn, $insert_user);

            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'member';
            header('location: ../index.php');
        } else {
            header('location: ../register.php');
        }
    }
?>