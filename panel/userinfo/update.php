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
                                        <h4 class="page-title m-0">ویرایش کردن اطاعات خود</h4>
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
                                    <form action="<?php echo '../'.pathBackend(); ?>userinfo.php/<?php echo $result->id; ?>" method="post" enctype="multipart/form-data">
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
                                            <label for="previous_password" class="col-sm-2 col-form-label">رمز قبلی</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="password" placeholder="رمز قبلی" name="previous_password"  id="previous_password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-2 col-form-label">رمز جدید</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="password" placeholder="رمز جدید" name="password"  id="password">
                                                <div> <?php echo errorInput('password'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="image" class="col-sm-2 col-form-label">تصویر</label>
                                            <div class="col-sm-10">
                                                <span style="color:red">حجم مجاز 4 مگابایت</span>
                                                <input class="form-control form-control-lg" type="file" name="image" id="image">
                                                <div> <?php echo errorInput('image'); ?></div>
                                                <div>
                                                    <?php if(!is_null($result->image)): ?>
                                                        <img src="<?php echo '../../../backEnd/'.$result->image; ?>" alt="<?php echo $result->username; ?>" width="120" height="120">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <?php
                                                if($result->id == $_SESSION['id'] and $result->username == $_SESSION['name'])
                                                    echo '<button type="submit" name="update" value="submit" class="col-sm-2 btn btn-success">ویرایش</button>';
                                                else
                                                    echo '<button onclick="alert(\'شما دسترسی لازم برای این کار را ندارید\')" class="col-sm-2 btn btn-dark errorAccess">ویرایش</button>';
                                                ?>
                                                <a href="../../index.php" class="col-sm-2 btn btn-danger">برگشت</a>
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