<?php
    session_start();
    include('db/server.php');
?>

<!DOCTYPE html>
<html lang="th">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>เข้าสู่ระบบ</title>
        <link rel="stylesheet" href="register-login.css">
        <link rel="stylesheet" href="nav.css">
    </head>

    <body>
        <nav>
            <div class="nav-content nav-left">
                <a href="index.php" class="nav-link">หน้าหลัก</a>
                <a href="market.php" class="nav-link">ร้านค้า</a>
            </div>
            <div class="nav-content nav-right">
                <?php if (isset($_SESSION['username'])) : ?>
                    <a href="profile.php" class="nav-link"><?php echo $_SESSION['username'] ?></a>
                    <a href="?logout='1'" class="nav-link">ออกจากระบบ</a>
                <?php else : ?>
                    <a href="login.php" class="nav-link">เข้าสู่ระบบ</a>
                    <a href="register.php" class="nav-link">สมัครสมาชิก</a>
                <?php endif ?>
            </div>
        </nav>

        <header>
            <h1>เข้าสู่ระบบ</h1>
        </header>

        <section>

            <div class="form-container">

                <form action="db/login_db.php" method="post">

                    <div class="input-group">

                        <p>
                            <label for="username">ชื่อผู้ใช้งาน</label>
                            <input type="text" name="username" required>
                        </p>

                        <p>
                            <label for="password">รหัสผ่าน</label>
                            <input type="password" name="password" required>
                        </p>

                    </div>

                    <div class="input-group">
                        <?php if (isset($_SESSION['error'])) : ?>
                            <p class="error">
                                <?php 
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                ?>
                            </p>
                        <?php endif ?>
                    </div>
                    
                    <p>
                        หากยังไม่มีบัญชีผู้ใช้ <a href="register.php" class="btn default">สมัครสมาชิก</a>
                    </p>

                    <button class="btn default" name="login-user">เข้าสู่ระบบ</button>

                </form>

            </div>

        </section>

        <footer>
            <p>โรงเรียนมาบตาพุดพันพิทยาคาร</p>
            <p>สำนักงานเขตพื้นที่การศึกษามัธยมศึกษาชลบุรี ระยอง</p>
        </footer>

    </body>
    
</html>