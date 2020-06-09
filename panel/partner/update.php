<?php include('../../backEnd/functions/backEndFunctions/layouts/header.php');
    $db = new DB();
    $id = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    $result = $db->find('partners','id',$id);
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
                                        <h4 class="page-title m-0">ویرایش کردن:<?php echo $result->username;?></h4>
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
                                    <form action="<?php echo '../'.pathBackend().'partner.php/'.$id; ?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label for="username" class="col-sm-2 col-form-label">نام</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" value="<?php echo $result->username ?>" placeholder="نام" name="username" id="username">
                                                <div>
                                                    <?php echo errorInput('username'); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="bio" class="col-sm-2 col-form-label">بیو</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control form-control-lg" name="bio" placeholder="بیو" id="bio" cols="30" rows="10"><?php echo $result->bio; ?></textarea>
                                                <div> <?php echo errorInput('bio'); ?></div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="instagram" class="col-sm-2 col-form-label">اینستاگرام</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" min="0" placeholder="اینستاگرام" value="<?php echo $result->instagram ?>" name="instagram" id="instagram">
                                                <div> <?php echo errorInput('instagram'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="twitter" class="col-sm-2 col-form-label">تویتر</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" min="0" placeholder="تویتر" value="<?php echo $result->twitter ?>" name="twitter" id="twitter">
                                                <div> <?php echo errorInput('twitter'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="facebook" class="col-sm-2 col-form-label">فیسبوک</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" min="0" placeholder="فیسبوک" value="<?php echo $result->facebook ?>" name="facebook" id="facebook">
                                                <div> <?php echo errorInput('facebook'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="image" class="col-sm-2 col-form-label">تصویر</label>
                                            <div class="col-sm-10">
                                                <span style="color:red">حجم مجاز 4 مگابایت</span>
                                                <input class="form-control form-control-lg" type="file" name="image" id="image">
                                                <div> <?php echo errorInput('image'); ?></div>
                                                <div><img src="<?php echo '../../../backEnd/'.$result->image; ?>" alt="<?php echo $result->username; ?>" width="120" height="120"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <?php
                                                if(ACL::update())
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