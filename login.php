<?php include("backEnd/functions/frontFunctions/layouts/header.php");?>

<div class="site-section" data-aos="fade">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="row mb-5">
                    <div class="col-12 ">
                        <h2 class="site-section-heading text-center">وارد شوید</h2>
                        <br><h6 class="text-center" style="">
                            <?php
                                if(isset($_SESSION['login']) and $_SESSION['login'] == 'error'){
                                    unset($_SESSION['login']);
                                    echo '<span class="alert alert-danger">پسورد یا رمز عبور اشتباه میباشد</span>';
                                }elseif(isset($_SESSION['manyLogin']) and $_SESSION['manyLogin'] == 'ok'){
                                    unset($_SESSION['manyLogin']);
                                    echo '<span class="alert alert-info">شما بیشتر از حد مجاز سعی کرده اید و تا 15 دقیقه بلاک شدید</span>';
                                }elseif(isset($_SESSION['register']) and $_SESSION['register'] == 'registered'){
                                    unset($_SESSION['register']);
                                    echo '<span class="alert alert-success">ثبت نام با موفقیت انجام شد</span>';
                                }elseif(isset($_SESSION['update']) and $_SESSION['update'] == 'ok'){
                                    unset($_SESSION['update']);
                                    echo '<span class="alert alert-success">رمز عبور با موفقیت ویرایش شد</span>';
                                }
                            ?>
                        </h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 mb-5">
                        <form action="backEnd/functions/frontFunctions/login.php" method="post">
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
                                    <span class="float-right"> مرا به خاط بسپار</span><input class="float-right" style="margin-top: 12px;margin-right: 5px;" type="checkbox" name="remmber" id="remmber">
                                    <a class="float-right" href="/photograph/forget-password.php" style="margin-right: 20px;">فراموشی رمز عبور<a>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <input type="submit" name="login" value="ورود" class="btn btn-primary py-2 px-4 text-white float-right">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include("backEnd/functions/frontFunctions/layouts/footer.php");?>
