<?php ob_start(); include("backEnd/functions/frontFunctions/layouts/header.php");
$db = new DB();
$check = isset($_GET['code']) ? $db->find('update_password','code', $_GET['code']) : false;
if(!empty($check)){
?>

<div class="site-section" data-aos="fade">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="row mb-5">
                    <div class="col-12 ">
                        <h2 class="site-section-heading text-center">ویرایش کردن رمز عبور</h2>
                        <br><h6 class="text-center">
                            <?php
                                if(isset($_SESSION['update']) and $_SESSION['update'] == 'error'){
                                    unset($_SESSION['update']);
                                    echo '<span class="alert alert-danger">مشکلی رخ داده است بعدا امتحان کنید</span>';
                                }
                            ?>
                        </h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 mb-5">
                        <form action="backEnd/functions/frontFunctions/forget.php?code=<?php echo $_GET['code']; ?>&email=<?php echo $check->email; ?>" method="post">
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
                                    <input type="submit" name="update_password" value="ویرایش" class="btn btn-primary py-2 px-4 text-white float-right">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include("backEnd/functions/frontFunctions/layouts/footer.php"); } else{ header('Location: '.$_ENV['FULL_URL']);};?>
