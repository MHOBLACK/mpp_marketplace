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

    $show_market = "SELECT * FROM market_list";
    $show_market_query = mysqli_query($conn, $show_market);
    $show_market_result = mysqli_fetch_all($show_market_query, MYSQLI_ASSOC);

    $show_user_rating = "SELECT * FROM rating_market WHERE voter = '$username'";
    $show_user_rating_query = mysqli_query($conn, $show_user_rating);
    $show_user_rating_result = mysqli_fetch_all($show_user_rating_query, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ | <?php echo $_SESSION['username'] ?></title>
    <link rel="stylesheet" href="profile-style.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>
    <nav>
        <div class="nav-content nav-left">
            <a href="index.php" class="nav-link">หน้าหลัก</a>
            <a href="guide.php" class="nav-link">เกี่ยวกับ</a>
            <a href="index.php#marketplace" class="nav-link">ร้านค้า</a>
        </div>
        <div class="nav-content nav-right">
            <?php if (isset($_SESSION['username'])) : ?>
                <a href="profile.php" class="nav-link nav-link-active"><?php echo $_SESSION['username'] ?></a>
                <a href="?logout='1'" class="nav-link">ออกจากระบบ</a>
            <?php else : ?>
                <a href="login.php" class="nav-link">เข้าสู่ระบบ</a>
                <a href="register.php" class="nav-link">สมัครสมาชิก</a>
            <?php endif ?>
        </div>
    </nav>

    <header>
        <h1>โปรไฟล์</h1>
        <p>ยินดีต้อนรับ, <?php echo $_SESSION['username'] ?></p>
    </header>

    <section>
        
        <?php if (isset($check_user_result)) : ?>

            <?php if ($check_user_result['role'] === "admin") : ?>

                <p>
                    <a href="manage_user.php" class="btn default">จัดการรายชื่อ</a>
                </p>

                <div class="container">

                    <div class="box insert-box">

                        <form action="add_market.php" method="post" enctype="multipart/form-data">

                            <h2>เพิ่มร้านค้า</h2>

                            <p>
                                <input type="file" name="market_img" accept="image/*" id="market_img" required>
                            </p>
                            
                            <div class="img-box">
                                <img id="previewImg">
                            </div>

                            <p>
                                <input type="text" name="market_name" placeholder="ชื่อร้าน" required>
                            </p>

                            <p>
                                <textarea name="market_content" cols="30" rows="10" placeholder="คำอธิบาย" required></textarea>
                            </p>

                            <p>
                                <input type="text" name="market_contact" placeholder="xxx-xxx-xxxx" required>
                            </p>

                            <p>
                                <input type="text" name="owner" placeholder="ชื่อผู้ใช้เจ้าของร้าน" required>
                            </p>

                            <p>
                                <button type="submit" class="btn default" name="add-market">เพิ่มร้านค้า</button>
                            </p>

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

                        </form>
                    </div>
                        
                </div>

            <?php endif ?>

        <?php endif ?>

        <?php if (isset($check_user_result)) : ?>

            <?php if ($check_user_result['role'] !== "admin") : ?>

                <div class="container">

                    <h1>ร้านค้าของคุณ</h1>

                    <div class="box-container">

                        <?php foreach ($show_market_result as $market) : ?>

                            <?php if ($market['owner'] === $_SESSION['username']) : ?>

                                <div class="box market-box">
                
                                    <div class="img-box">
                                        <img src="<?php echo $market['market_img'] ?>" alt="ภาพ <?php echo $market['market_name'] ?>">
                                    </div>
                
                                    <h2><?php echo $market['market_name'] ?></h2>
                                    <p><?php echo $market['market_content'] ?></p>
                                    <p>เบอร์ติดต่อ : <?php echo $market['market_contact'] ?></p>

                                    <?php if (!empty($_SESSION['username'])) : ?>

                                        <?php if ($market['owner'] === $_SESSION['username']) : ?>
                                            <p>
                                                <b>คุณเป็นเจ้าของร้านนี้</b>
                                            </p>
                                            <div class="admin-box">
                                                <a href="edit_market.php?edit_market_id=<?php echo $market['market_id'] ?>&market_name=<?php echo $market['market_name'] ?>" class="btn edit-market">แก้ไข</a>
                                                <a href="delete_market.php?delete_market_id=<?php echo $market['market_id'] ?>" class="btn delete-market">ลบ</a>
                                            </div>
                                        <?php endif ?>

                                    <?php endif ?>

                                    <div class="box-button">
                                        <a href="market.php?market_name=<?php echo $market['market_name'] ?>" class="btn default">เยี่ยมชมร้านค้า</a>
                                    </div>
                
                                </div>

                            <?php endif ?>
            
                        <?php endforeach ?>

                    </div>

                </div>

                <div class="container">

                    <h1>การรีวิวของคุณ</h1>

                    <div class="box-container">

                        <?php foreach ($show_market_result as $market) : ?>

                            <?php foreach ($show_user_rating_result as $user_rating) : ?>

                                    <div class="box market-box">

                                        <div class="img-box">
                                            <img src="<?php echo $market['market_img'] ?>" alt="ภาพ <?php echo $market['market_name'] ?>">
                                        </div>
                    
                                        <h2><?php echo $user_rating['market_name'] ?></h2>
                                        <p><?php echo $user_rating['rate'] ?> คะแนน</p>
                                        <p>
                                            <a href="market.php?market_name=<?php echo $user_rating['market_name'] ?>" class="btn default">เยี่ยมชมร้านค้า</a>
                                        </p>
                    
                                    </div>
                
                            <?php endforeach ?>

                        <?php endforeach ?>

                    </div>

                </div>

            <?php endif ?>

        <?php endif ?>

    </section>

    <footer>
        <p>โรงเรียนมาบตาพุดพันพิทยาคาร</p>
        <p>สำนักงานเขตพื้นที่การศึกษามัธยมศึกษาชลบุรี ระยอง</p>
    </footer>

    <script>
        let imgInput = document.querySelector('#market_img');
        let previewImg = document.querySelector('#previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }
    </script>
</body>
</html>