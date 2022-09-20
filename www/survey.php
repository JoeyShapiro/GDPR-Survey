<?php
    include_once("header.php");

    $placement = 'style="bottom: 0;"';

    if (in_array($_SESSION['version'], array('1', '2', '5', '6', '9', '10', '13', '14'))) {
        $placement = 'style="top: 0;"';
    }

    if(array_key_exists('accepted', $_POST)) {
        accept();
    }
    else if(array_key_exists('declined', $_POST)) {
        decline();
    }
    function accept() {
        $_SESSION['cookie'] = 'Accept Cookie';
    }
    function decline() {
        $_SESSION['cookie'] = 'Deny Cookie';
    }

    if (!isset($_SESSION['cookie'])) {
        $stmt = $conn->prepare("INSERT INTO survey (RID, version, page_accessed, time_accessed, action) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $_SESSION['rid'], $_SESSION['version'], $page_accessed, $time_accessed, $action);
    
        // set parameters and execute
        $page_accessed = "survey.php";
        $time_accessed = date('Y-m-d H:i:s');
        $action = $_SESSION['cookie'];
    
        $stmt->execute();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="styles/bootstrap-5.0.2-dist/css/bootstrap.min.css">
        <!-- Custom -->
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Healthy People</a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Health A-Z <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Drugs and Suppliments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Living Healthy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Family and Pregnancy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">News and Experts</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <!-- image of woman -->
    <a href="wellbeing.php">
        <img src="img/Picture1.png" alt="vaccine" style="width:100%;height:auto;">
    </a>

    <!-- cookie consent popup -->
    <?php if (!isset($_SESSION['cookie'])) : ?>
    <!-- colors (reference the truth table, this is hard to explain) -->
    <?php if (($_SESSION['version'] < 5) || ($_SESSION['version'] > 8 && $_SESSION['version'] < 13)) : ?>
    <div class="cookie-consent-banner-black" <?php echo $placement ?>>
    <?php else : ?>
    <div class="cookie-csonsent-banner-white" <?php echo $placement ?>>
    <?php endif; ?>
        <div class="cookie-consent-banner__inner">
            <div class="cookie-consent-banner__copy">
                <div class="cookie-consent-banner__header">THIS WEBSITE USES COOKIES</div>
                <div class="cookie-consent-banner__description">
                <?php if ($_SESSION['version'] < 9) : ?> <!-- if the first half of versions -->
                    To give you the best possible experience, this site uses cookies and by
                    continuing to use the site you agree that we can save them on your device.
                    Cookies are small text files which are placed on your computer and which
                    remember your preferences/some details of your visit. Our cookies don't
                    collect personal information.
                <?php else : ?>
                    This website uses cookies to ensure you get the best experience on our
                    website.
                <?php endif; ?>
                     For more information, please read our updated <a href="cookie.php">privacy and
                    cookie policy</a>.
                </div>
            </div>

            <div class="cookie-consent-banner__actions">
                <form method="post">
                    <button type="submit" name="accepted" class="cookie-consent-banner__cta">
                        Got It!
                    </button>
                    
                    <!-- only show decline if odd version number -->
                    <?php if ($_SESSION['version'] % 2 != 0) : ?>
                    <button type="submit" name="declined" class="cookie-consent-banner__cta cookie-consent-banner__cta--secondary">
                        Decline!
                    </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

</body>
</html>