<?php
    include_once("header.php");

    $stmt = $conn->prepare("INSERT INTO survey (RID, version, page_accessed, time_accessed, action) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $_SESSION['rid'], $_SESSION['version'], $page_accessed, $time_accessed, $action);

    // set parameters and execute
    $page_accessed = "cookie.php";
    $time_accessed = date('Y-m-d H:i:s');
    $action = 'View Policy';

    $stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Policy</title>
</head>
<body>
    <img src="img/about_cookies.png" alt="about cookies" style="width:100%;height:auto;">
</body>
</html>
