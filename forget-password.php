<?php include("backEnd/functions/frontFunctions/layouts/header.php");?>

<div class="site-section" data-aos="fade">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="row mb-5">
                    <div class="col-12 ">
                        <h4 class="text-center">برای بازیابی رمز عبور ایمیل خود را وارد کنید</h4>
                        <br><h6 class="text-center">
                            <?php
                            if(isset($_SESSION['forget']) and $_SESSION['forget'] == 'ok'){
                                unset($_SESSION['forget']);
                                echo '<span class="alert alert-success">یک ایمیل تاییدیه برای شما ارسال شد</span>';
                            }elseif(isset($_SESSION['forget']) and $_SESSION['forget'] == 'error'){
                                unset($_SESSION['forget']);
                                echo '<span class="alert alert-danger">یا مشکلی پیش امده است یا ایمیل شما نامعتر است بعدا امتحان کنید</span>';
                            }
                            ?>
                        </h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 mb-5">
                        <form action="backEnd/functions/frontFunctions/forget.php" method="post">
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
                                    <input type="submit" name="forget" value="ارسال" class="btn btn-primary py-2 px-4 text-white float-right">
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
