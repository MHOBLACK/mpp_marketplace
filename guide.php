<?php
    session_start();
    include('db/server.php');

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header('location: index.php');
    }

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $check_user = "SELECT * FROM user WHERE username = '$username'";
        $check_user_query = mysqli_query($conn, $check_user);
        $check_user_result = mysqli_fetch_assoc($check_user_query);
    }

    $show_user = "SELECT * FROM user";
    $show_user_query = mysqli_query($conn, $show_user);
    $show_user_result = mysqli_fetch_all($show_user_query, MYSQLI_ASSOC);

    if (isset($_GET['delete_user_id'])) {
        $user_id = $_GET['delete_user_id'];
        $delete_user = "DELETE FROM user WHERE id = $user_id";
        mysqli_query($conn, $delete_user);
        header('location: manage_user.php');
    }

    if (isset($_GET['save-user'])) {
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        $username_input = mysqli_real_escape_string($conn, $_GET['username']);
        $password_input = mysqli_real_escape_string($conn, $_GET['password']);
        $role_input = mysqli_real_escape_string($conn, $_GET['role']);

        $update_user = "UPDATE user SET username = '$username_input', password = '$password_input', role = '$role_input' WHERE id = $user_id";
        mysqli_query($conn, $update_user);
        header('location: manage_user.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>เกี่ยวกับ</title>
        <link rel="stylesheet" href="profile-style.css">
        <link rel="stylesheet" href="nav.css">
    </head>

    <body>

        <nav>
            <div class="nav-content nav-left">
                <a href="index.php" class="nav-link">หน้าหลัก</a>
                <a href="guide.php" class="nav-link nav-link-active">เกี่ยวกับ</a>
                <a href="index.php#marketplace" class="nav-link">ร้านค้า</a>
            </div>
            <div class="nav-content nav-right">
                <?php if (isset($_SESSION['username'])) : ?>
                    <a href="profile.php" class="nav-link"><?php echo $_SESSION['username'] ?></a>
                    <a href="?logout='1'" class="nav-link">ออกจากระบบ</a>
                <?php else : ?>
                    <a href="" class="nav-link">เข้าสู่ระบบ</a>
                    <a href="" class="nav-link">สมัครสมาชิก</a>
                <?php endif ?>
            </div>
        </nav>

        <header>
            <h1>เกี่ยวกับ</h1>
        </header>

        <section style="text-align: left;">

            <div class="container">

                <div class="box-container-user-list">

                    <div class="box user-table-list" style="background-color: #00b3ff; color: #fff; grid-template-columns: 1fr; text-align: left;">

                        <div class="user-info">
                            <h3>เว็ปไซต์นี้คืออะไร?</h3>
                        </div>

                    </div>

                    <div class="box user-content-list">

                        <div class="user-info">
                            <p>เว็ปไซต์นี้เป็นเว็ปไซต์ที่ถูกจัดทำขึ้น <b>เพื่อเป็นแนวทางในการแข่งขันฝึกซ้อมงานศิลปหัตถกรรมนักเรียน การแข่งขันการสร้าง Web Applications ม.4-ม.6</b> โดยเว็ปไซต์นี้จัดทำขึ้นเมื่อวันที่ 27 มกราคม 2566 พัฒนาโดยใช้ภาษา HTML  CSS  JavaScript  PHP และ SQL</p>
                            <div class="box-team-info">
                                <div class="team-info">
                                    <img src="img/team/chatchai.jpg" alt="">
                                    <div class="team-desc">
                                        <h2>นายฉัตรชัย โชติสวัสดิ์</h2>
                                        <p>ศิษย์เก่าโรงเรียนมาบตาพุดพันพิทยาคาร รุ่นที่ ๔๔</p>
                                        <p>คณะวิทยาศาสตร์ สาขาวิทยาการคอมพิวเตอร์ มหาวิทยาลัยเกษตรศาสตร์</p>
                                        <p>ช่องทางการติดต่อ <a href="https://linktr.ee/pepozx" class="btn default">คลิกที่นี่</a></p>
                                    </div>
                                </div>
                            </div>
                            <p>สามารถดู Source Code ของเว็ปไซต์ได้ที่ <a href="" class="btn default">GitHub</a></p>
                        </div>

                    </div>

                    <div class="box user-table-list" style="background-color: #00b3ff; color: #fff; grid-template-columns: 1fr; text-align: left;">

                        <div class="user-info">
                            <h3>เว็ปไซต์นี้สามารถนำไปใช้ในทางใดได้บ้าง?</h3>
                        </div>

                    </div>

                    <div class="box user-content-list">

                        <div class="user-info">
                            <p>สามารถนำไปใช้งานส่วนตัวหรือเพื่อการศึกษาได้ <b style="color: #FF1A00;">แต่ไม่อนุญาตนำไปใช้ในเชิงพาณิชย์</b> หากพบการกระทำดังกล่าวจะดำเนินคดีตาม<a href="https://citcoms.nu.ac.th/wp-content/uploads/2018/03/law-computer2560.pdf">พระราชบัญญัติว่าด้วยการกระทำความผิดเกี่ยวกับคอมพิวเตอร์ พ.ศ.2560</a></p>
                        </div>

                    </div>

                    <div class="box user-table-list" style="background-color: #00b3ff; color: #fff; grid-template-columns: 1fr; text-align: left;">

                        <div class="user-info">
                            <h3>ระบบของเว็ปไซต์มีอะไรบ้าง?</h3>
                        </div>

                    </div>

                    <div class="box user-content-list">

                        <div class="user-info">
                            <ul>
                                <li>ผู้ใช้งาน
                                    <ul>
                                        <li><b>เพิ่ม / ลบ / แก้ไข</b> ข้อมูลผู้ใช้งาน</li>
                                    </ul>
                                </li>
                                <li>ร้านค้า
                                    <ul>
                                        <li><b>เพิ่ม / ลบ / แก้ไข</b> ข้อมูลร้านค้า</li>
                                        <li><b>ให้คะแนนรีวิว</b> ร้านค้า</li>
                                    </ul>
                                </li>
                                <li>สินค้า
                                    <ul>
                                        <li><b>เพิ่ม / ลบ / แก้ไข</b> ข้อมูลสินค้า</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                    </div>


                </div>

            </div>

        </section>


    </body>
</html>