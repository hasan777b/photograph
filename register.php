<?php ob_start(); include("backEnd/functions/frontFunctions/layouts/header.php");
$db = new DB();
$user = $db->getOneRow('users');
if(empty($user)):
?>

<div class="site-section" data-aos="fade">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="row mb-5">
                    <div class="col-12 ">
                        <h2 class="site-section-heading text-center">ثبت نام</h2>
                        <h5 class="text-center" style="color:red;">این صفحه یک بار قابل دسترس است در وارد کردن اطلاعات دقت کنید</h5>
                        <br><h6 class="text-center">
                            <?php echo errorMessage() ?>
                        </h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 mb-5">
                        <form action="backEnd/functions/frontFunctions/register.php" method="post">
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label class="text-black float-right" for="email">نام</label>
                                    <input type="text" id="username" name="username" class="form-control"><br>
                                    <?php
                                    if(isset($_SESSION['username'])) {
                                        echo '<span class="alert alert-danger">' . $_SESSION['username'] . '</span>';
                                        unset($_SESSION['username']);
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label class="text-black float-right" for="email">ایمیل</label>
                                    <input type="email" id="email" name="email" class="form-control"><br>
                                    <?php
                                    if(isset($_SESSION['email'])) {
                                        echo '<span class="alert alert-danger">' . $_SESSION['email'] . '</span>';
                                        unset($_SESSION['email']);
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label class="text-black float-right" for="password">پسورد</label>
                                    <input type="password" id="password" name="password" class="form-control"><br>
                                    <?php
                                    if(isset($_SESSION['password'])) {
                                        echo '<span class="alert alert-danger" style="direction: rtl">' . $_SESSION['password'] . '</span>';
                                        unset($_SESSION['password']);
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <input type="submit" name="register" value="ثبت نام" class="btn btn-primary py-2 px-4 text-white float-right">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include("backEnd/functions/frontFunctions/layouts/footer.php"); else: header('Location: /photograph/login.php');endif;?>
