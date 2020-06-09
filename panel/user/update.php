<?php include('../../backEnd/functions/backEndFunctions/layouts/header.php');
    $db = new DB();
    $result = $db->find('users','id',$db->fixParameterUrl($_SERVER['PATH_INFO']));
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
                                        <h4 class="page-title m-0">ویرایش کردن کاربر:<?php echo $result->username;?></h4>
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
                                    <form action="<?php echo '../'.pathBackend(); ?>user.php/<?php echo $result->id; ?>" method="post">
                                        <div class="form-group row">
                                            <label for="username" class="col-sm-2 col-form-label">نام</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" placeholder="نام" name="username" value="<?php echo $result->username; ?>" id="username">
                                                <div>
                                                    <?php echo errorInput('username'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">ایمیل</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="email" placeholder="ایمیل" name="email" value="<?php echo $result->email; ?>" id="email">
                                                <div> <?php echo errorInput('email'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-2 col-form-label">رمز عبور</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="password" placeholder="رمز عبور را خالی بگذارید رمز عبور قبلی ثبت میشود" name="password"  id="password">
                                                <div> <?php echo errorInput('password'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="access" class="col-sm-2 col-form-label">دسترسی</label>
                                            <div class="col-sm-10">
                                                <select class="form-control form-control-lg" name="access" id="access">
                                                    <?php
                                                        $access = ACL::getAccessName($result->id);
                                                        $a = ACL::getAccessName($_SESSION['id']);
                                                        if($a == 'مدیر'){
                                                            echo '<option value="1"';
                                                            echo $access == "مدیر" ? "selected" : "";
                                                            echo '>مدیر</option>';
                                                        }
                                                    ?>
                                                    <option value="2" <?php echo $access == "ادمین" ? "selected" : ""; ?>>ادمین</option>
                                                    <option value="3" <?php echo $access == "نویسنده" ? "selected" : ""; ?>>نویسنده</option>
                                                    <option value="4" <?php echo $access == "ویرایشگر" ? "selected" : ""; ?>>ویرایشگر</option>
                                                    <option value="5" <?php echo $access == "حذف کننده" ? "selected" : ""; ?>>حذف کننده</option>
                                                    <option value="6" <?php echo $access == "مشاهده کننده" ? "selected" : ""; ?>>مشاهده کننده</option>
                                                </select>
                                                <div> <?php echo errorInput('access'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <?php
                                                if(ACL::manager())
                                                    echo '<button type="submit" name="update" value="submit" class="col-sm-2 btn btn-success">ویرایش</button>';
                                                else
                                                    echo '<button onclick="alert(\'شما دسترسی لازم برای این کار را ندارید\')" class="col-sm-2 btn btn-dark errorAccess">ویرایش</button>';
                                                ?>
                                                <a href="../index.php" class="col-sm-2 btn btn-danger">برگشت</a>
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