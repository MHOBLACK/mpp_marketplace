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
        <title>จัดการรายชื่อ</title>
        <link rel="stylesheet" href="profile-style.css">
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
                    <a href="" class="nav-link">เข้าสู่ระบบ</a>
                    <a href="" class="nav-link">สมัครสมาชิก</a>
                <?php endif ?>
            </div>
        </nav>

        <section>
            
            <?php if (isset($check_user_result)) : ?>
    
                <?php if ($check_user_result['role'] === "admin") : ?>
    
                    <div class="container">
                        <h2 style="text-align: center;">จัดการรายชื่อ</h2>
    
                        <div class="box-container-user-list">
    
                            <div class="box user-table-list" style="background-color: #00b3ff; color: #fff;">
    
                                <div class="user-info">
                                    <h3>ไอดี</h3>
                                </div>
    
                                <div class="user-info">
                                    <h3>ชื่อผู้ใช้</h3>
                                </div>
    
                                <div class="user-info">
                                    <h3>รหัสผ่าน</h3>
                                </div>
    
                                <div class="user-info">
                                    <h3>ตำแหน่ง</h3>
                                </div>
    
                                <div class="user-manage">
                                    <h3>จัดการ</h3>
                                </div>
    
                            </div>
    
                            <?php foreach ($show_user_result as $user) : ?>
    
                                <?php if (isset($_GET['edit_user_id'] )) : ?>
    
                                    <?php if ($_GET['edit_user_id'] == $user['id']) : ?>
    
                                        <form action="" method="get">
    
                                            <div class="box user-list">
    
                                                <div class="user-info">
    
                                                    <input name="user_id" type="text" value="<?php echo $user['id'] ?>" readonly>
    
                                                </div>
    
                                                <div class="user-info">
    
                                                    <input name="username" type="text" value="<?php echo $user['username'] ?>">
    
                                                </div>
    
                                                <div class="user-info">
    
                                                    <input name="password" type="text" value="<?php echo $user['password'] ?>">
    
                                                </div>
    
                                                <div class="user-info">
    
                                                    <select name="role">
    
                                                        <?php if ($user['role'] == 'admin') : ?>
                                                            <option value="admin" selected>admin</option>
                                                            <option value="member">member</option>
                                                        <?php else : ?>
                                                            <option value="admin">admin</option>
                                                            <option value="member" selected>member</option>
                                                        <?php endif ?>
    
                                                    </select>
    
                                                </div>
    
                                                <div class="user-manage">
                                                    <p>
                                                        <button name="save-user" class="btn create-data">บันทึก</button>
                                                        <a href="manage_user.php" class="btn delete-market">ยกเลิก</a>
                                                    </p>
                                                </div>
    
                                            </div>
    
                                        </form>
    
    
                                    <?php endif ?>
    
                                <?php else : ?>
    
                                    <div class="box user-list">
    
                                        <div class="user-info">
                                            
                                            <p><?php echo $user['id'] ?></p>
    
                                        </div>
    
                                        <div class="user-info">
                                            
                                            <p><?php echo $user['username'] ?></p>
    
                                        </div>
    
                                        <div class="user-info">
                                            
                                            <p><?php echo $user['password'] ?></p>
    
                                        </div>
    
                                        <div class="user-info">
                                            
                                            <p><?php echo $user['role'] ?></p>
    
                                        </div>
    
                                        <div class="user-manage">
    
                                            <p>
                                                <a href="?edit_user_id=<?php echo $user['id'] ?>" class="btn edit-market">แก้ไข</a>
                                                <a href="?delete_user_id=<?php echo $user['id'] ?>" class="btn delete-market">ลบ</a>
                                            </p>
    
                                        </div>
                                    
                                    </div>
    
                                <?php endif ?>
    
                            <?php endforeach ?>
                            
                        </div>
    
                    </div>
    
                <?php endif ?>
    
            <?php endif ?>

        </section>


    </body>
</html>