<?php

    // เชื่อมต่อกับฐานข้อมูล phpmyadmin
    
    $hostname = 'localhost'; // IP Address หรือ Hostname ของฐานข้อมูล
    $username = 'root'; // username ของฐานข้อมูล
    $password = ''; // password ของฐานข้อมูล ถ้ามีให้ใส่เข้าไป ถ้าไม่มีก็เว้นว่างไว้
    $database = 'marketplace'; // ชื่อ Database ของเราที่สร้าง

    // สร้างตัวแปรที่เชื่อมต่อกับฐานข้อมูล
    $conn = mysqli_connect($hostname, $username, $password, $database);

    // ตรวจเงื่อนไขว่าหากไม่สามารถเชื่อมต่อกับฐานข้อมูลได้
    if (!$conn) {
        die("ไม่สามารถเชื่อมต่อฐานข้อมูลได้ " . mysqli_connect_error());
    } else {
        echo "";
    }

?>