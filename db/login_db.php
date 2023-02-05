<?php
    session_start();
    include('server.php');

    $error = array();

    if (isset($_POST['login-user'])) {

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (count($error) == 0) {
            // นำ "//" ออก หากต้องการให้มีการเข้ารหัส
            // $password = md5($password); 

            $user_check = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
            $user_check_query = mysqli_query($conn, $user_check);
            $user_check_result = mysqli_fetch_assoc($user_check_query);

            if (mysqli_num_rows($user_check_query) == 1) {
                $_SESSION['username'] = $username;
                $_SESSION['birthdate'] = $user_check_result['role'];

                header('location: ../index.php');
            } else {
                array_push($error, "ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง");
                $_SESSION['error'] = "ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง";
                header('location: ../login.php');
            }

        } else {
            header('location: ../login.php');
        }
    }
?>