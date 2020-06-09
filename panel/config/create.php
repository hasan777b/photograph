<?php ob_start(); include('../../backEnd/functions/backEndFunctions/layouts/header.php');
$db = new DB();
$result = $db->get('config');
if(!empty($result)){
    header('Location: ../config/index.php');
}
?>
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="page-content-wrapper ">

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title-box">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h4 class="page-title m-0">اضافه کردن کانفیگ</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="float-right d-none d-md-block">

                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end page-title-box -->
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <?php echo errorMessage() ?>
                                    <form action="<?php echo pathBackend(); ?>config.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 col-form-label">تلفن</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="number" placeholder="تلفن" name="phone" id="phone">
                                                <div>
                                                    <?php echo errorInput('phone'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">ایمیل</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="email" placeholder="ایمیل" name="email" id="email">
                                                <div>
                                                    <?php echo errorInput('email'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="address" class="col-sm-2 col-form-label">ادرس</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" placeholder="ادرس" name="address" id="address">
                                                <div>
                                                    <?php echo errorInput('address'); ?>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="instagram" class="col-sm-2 col-form-label">اینستاگرام</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" min="0" placeholder="اینستاگرام" name="instagram" id="instagram">
                                                <div> <?php echo errorInput('instagram'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="twitter" class="col-sm-2 col-form-label">تویتر</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" min="0" placeholder="تویتر" name="twitter" id="twitter">
                                                <div> <?php echo errorInput('twitter'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="facebook" class="col-sm-2 col-form-label">فیسبوک</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" min="0" placeholder="فیسبوک" name="facebook" id="facebook">
                                                <div> <?php echo errorInput('facebook'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="youtube" class="col-sm-2 col-form-label">یوتیوب</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" min="0" placeholder="یوتیوب" name="youtube" id="youtube">
                                                <div> <?php echo errorInput('youtube'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="footer" class="col-sm-2 col-form-label">فوتر</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" placeholder="فوتر" name="footer" id="footer">
                                                <div>
                                                    <?php echo errorInput('footer'); ?>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="logo" class="col-sm-2 col-form-label">لوگو</label>
                                            <div class="col-sm-10">
                                                <span style="color:red">حجم مجاز 4 مگابایت</span>
                                                <input class="form-control form-control-lg" type="file" name="logo" id="logo">
                                                <div> <?php echo errorInput('logo'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <?php
                                                    if(ACL::create())
                                                        echo '<button type="submit" name="create" value="submit" class="col-sm-2 btn btn-success">ثبت</button>';
                                                    else
                                                        echo '<button onclick="alert(\'شما دسترسی لازم برای این کار را ندارید\')" class="col-sm-2 btn btn-dark errorAccess">ثبت</button>';
                                                ?>
                                                <a href="index.php" class="col-sm-2 btn btn-danger">برگشت</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php include('../../backEnd/functions/backEndFunctions/layouts/footer_.php');?>