<?php
include($_SERVER['DOCUMENT_ROOT']."/photograph/backEnd/functions/backEndFunctions/globalFunctions.php");
$db = new DB();
$user = Auth::user();
$config = config();
$categories = $db->get('categories', false,'','ORDER BY `position` ASC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $_ENV['APP_NAME']; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300i,400,700" rel="stylesheet">
    <link rel="stylesheet" href="/photograph/assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="/photograph/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/photograph/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="/photograph/assets/css/jquery-ui.css">
    <link rel="stylesheet" href="/photograph/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/photograph/assets/css/owl.theme.default.min.css">

    <link rel="stylesheet" href="/photograph/assets/css/lightgallery.min.css">

    <link rel="stylesheet" href="/photograph/assets/css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="/photograph/assets/fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="/photograph/assets/css/swiper.css">

    <link rel="stylesheet" href="/photograph/assets/css/aos.css">

    <link rel="stylesheet" href="/photograph/assets/css/style.css">
    <link rel="stylesheet" href="/photograph/assets/css/css.css">

</head>
<body>

<div class="site-wrap">

    <div class="site-mobile-menu">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>




    <header class="site-navbar py-3" role="banner">

        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-6 col-xl-2" data-aos="fade-down">
                    <h1 class="mb-0"><a href="/photograph/index.php" class="text-black h2 mb-0">فوتون</a></h1>
                    <br><div class="btn btn-outline-dark">
                        <?php
                        if(empty($user)){
                            echo '<a style="font-size: 15px;color:orange !important;" href="login.php" class="text-black h2 mb-0">ورود</a>';
                        }else{
                            echo '<a style="font-size: 15px;color:orange !important;" href="panel/index.php" class="text-black h2 mb-0">پنل مدیریت</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="col-10 col-md-8 d-none d-xl-block" data-aos="fade-down">
                    <nav class="site-navigation position-relative text-right text-lg-center" role="navigation">

                        <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block">
                            <li class="active"><a href="/photograph/index.php">خانه</a></li>
                            <li class="has-children">
                                <a style="cursor: pointer;">گالری</a>
                                <ul class="dropdown">
                                    <?php foreach ($categories as $category): ?>
                                    <li><a href="<?php echo '/photograph/single.php/'.$category->slug; ?>"><?php echo $category->title; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <li><a href="/photograph/services.php">سرویس ها</a></li>
                            <li><a href="/photograph/about.php">درباره ما</a></li>
                            <li><a href="/photograph/contact.php">تماس با ما</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="col-6 col-xl-2 text-right" data-aos="fade-down">
                    <div class="d-none d-xl-inline-block">
                        <ul class="site-menu js-clone-nav ml-auto list-unstyled d-flex text-right mb-0" data-class="social">
                            <li>
                                <a href="<?php echo !empty($config->facebook) ? $config->facebook : ''; ?>" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                            </li>
                            <li>
                                <a href="<?php echo !empty($config->twitter) ? $config->twitter : ''; ?>" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                            </li>
                            <li>
                                <a href="<?php echo !empty($config->instagram) ? $config->instagram : ''; ?>" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                            </li>
                            <li>
                                <a href="<?php echo !empty($config->youtube) ? $config->youtube : ''; ?>" class="pl-3 pr-3"><span class="icon-youtube-play"></span></a>
                            </li>
                        </ul>
                    </div>

                    <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

                </div>

            </div>
        </div>

    </header>

