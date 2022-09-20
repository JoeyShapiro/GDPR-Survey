<?php
    include_once("header.php");

    // generate random id, first 3 numbers are random
    $_SESSION['rid'] = rand(100, 999) . time();
    $_SESSION['version'] = rand(1, 16);

    // prepare and bind
    $stmt = $conn->prepare("INSERT INTO survey (RID, version, page_accessed, time_accessed, action) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $_SESSION['rid'], $_SESSION['version'], $page_accessed, $time_accessed, $action);

    // set parameters and execute
    $page_accessed = "index.php";
    $time_accessed = date('Y-m-d H:i:s');
    $action = "Start";

    $stmt->execute();

    header("Location: survey.php");
    die();
?>