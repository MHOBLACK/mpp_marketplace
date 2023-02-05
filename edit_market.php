<?php 
    session_start();
    include('db/server.php');

    $error = array();

    $market_name = $_GET['market_name'];
    $market_id = $_GET['edit_market_id'];

    $market_list = "SELECT * FROM market_list WHERE market_id = $market_id";
    $market_list_query = mysqli_query($conn, $market_list);
    $market_list_result = mysqli_fetch_all($market_list_query, MYSQLI_ASSOC);

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $check_user = "SELECT * FROM user WHERE username = '$username'";
        $check_user_query = mysqli_query($conn, $check_user);
        $check_user_result = mysqli_fetch_assoc($check_user_query);
    }

    $user_list = "SELECT * FROM user WHERE role <> 'admin'";
    $user_list_query = mysqli_query($conn, $user_list);
    $user_list_result = mysqli_fetch_all($user_list_query, MYSQLI_ASSOC);

    if (isset($_POST['save'])) {

        $market_name_input = mysqli_real_escape_string($conn, $_POST['market_name']);
        $market_content_input = mysqli_real_escape_string($conn, $_POST['market_content']);
        $market_contact_input = mysqli_real_escape_string($conn, $_POST['market_contact']);
        $market_owner = mysqli_real_escape_string($conn, $_POST['market_owner']);

        $dir = "img/upload/market_list/";
        $fileImage = $dir . basename($_FILES['market_img']['name']);

        if (move_uploaded_file($_FILES['market_img']['tmp_name'], $fileImage) || isset($_POST['market_name']) || isset($_POST['market_content']) || isset($_POST['market_contact'])) {

            if (empty($_FILES['market_img']['tmp_name'])) {
                $update_market = "UPDATE market_list SET market_name = '$market_name_input', market_content = '$market_content_input', market_contact = '$market_contact_input', owner = '$market_owner' WHERE market_id = $market_id";
                mysqli_query($conn, $update_market);
            } else {
                $update_market = "UPDATE market_list SET market_img = '$fileImage', market_name = '$market_name_input', market_content = '$market_content_input', market_contact = '$market_contact_input', owner = '$market_owner' WHERE market_id = $market_id";
                mysqli_query($conn, $update_market);
            }

            $_SESSION['success'] = "อัพเดตข้อมูลสำเร็จ";
            header('location: index.php');
        } else {
            array_push($error, "อัพโหลดข้อมูลไม่สำเร็จ");
            $_SESSION['error'] = "อัพโหลดข้อมูลไม่สำเร็จ";
            header('location: index.php');
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>แก้ไขร้านค้า | <?php echo $market_name ?></title>
        <link rel="stylesheet" href="edit-style.css">
        <link rel="stylesheet" href="nav.css">
    </head>
<body>

    <header>

        <h2>แก้ไขร้านค้า | <?php echo $market_name ?></h2>

    </header>
    
    <section>

        <?php foreach ($market_list_result as $market) : ?>
    
            <div class="box-market">

                <form action="" method="post" enctype="multipart/form-data">

                    <div class="market-img">

                        <img src="<?php echo $market['market_img'] ?>" alt="<?php echo $market['market_name'] ?>" id="previewImg">

                    </div>

                    <div class="market-desc">

                        <?php if ($check_user_result['role'] === "admin") : ?>

                            <p>
                                <input type="file" name="market_img" id="market_img" hidden>
                            </p>

                            <p class="label">ชื่อร้าน</p>

                            <p>
                                <input type="text" name="market_name" placeholder="ชื่อร้าน" value="<?php echo $market['market_name'] ?>" style="font-size: 1.5rem;" readonly>
                            </p>

                            <p class="label">รายละเอียด</p>

                            <p>
                                <textarea name="market_content" placeholder="รายละเอียด" readonly><?php echo nl2br($market['market_content']) ?></textarea>
                            </p>

                            <p class="label">เบอร์ติดต่อ</p>

                            <p>
                                <input type="text" name="market_contact" placeholder="xxx-xxx-xxxx" value="<?php echo $market['market_contact'] ?>" readonly>
                            </p>
                            
                            <p class="label">เจ้าของ</p>

                            <p>
                                <select name="market_owner">
                                    <?php foreach ($user_list_result as $user) : ?>
                                        <?php if ($market['owner'] == $user['username']) : ?>
                                            <option value="<?php echo $user['username'] ?>" selected><?php echo $user['username'] ?></option>
                                        <?php else : ?>
                                            <option value="<?php echo $user['username'] ?>"><?php echo $user['username'] ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>    
                                </select>
                            </p>

                            <p>
                                <button type="submit" name="save" class="btn">บันทึก</button>
                                <a href="index.php" class="btn">ย้อนกลับ</a>
                            </p>

                        <?php endif ?>

                        <?php if ($market['owner'] === $username) : ?>

                            <p class="label">รูปภาพ</p>

                            <p>
                                <input type="file" name="market_img" id="market_img">
                            </p>

                            <p class="label">ชื่อร้าน</p>

                            <p>
                                <input type="text" name="market_name" placeholder="ชื่อร้าน" value="<?php echo $market['market_name'] ?>" style="font-size: 1.5rem;">
                            </p>

                            <p class="label">รายละเอียด</p>

                            <p>
                                <textarea name="market_content" placeholder="รายละเอียด"><?php echo nl2br($market['market_content']) ?></textarea>
                            </p>

                            <p class="label">เบอร์ติดต่อ</p>

                            <p>
                                <input type="text" name="market_contact" placeholder="xxx-xxx-xxxx" value="<?php echo $market['market_contact'] ?>">
                            </p>

                            <p>
                                <button type="submit" name="save" class="btn">บันทึก</button>
                                <a href="index.php" class="btn">ย้อนกลับ</a>
                            </p>

                        <?php endif ?>

                    </div>

                    <?php if (isset($_SESSION['error'])) : ?>
                        <p class="error">
                            <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </p>
                    <?php endif ?>

                </form>
            </div>
    
        <?php endforeach ?>
    </section>
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