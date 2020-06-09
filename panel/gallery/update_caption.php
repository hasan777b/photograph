<?php include('../../backEnd/functions/backEndFunctions/layouts/header.php');
$db = new DB();
$id = explode('/',$_SERVER['PATH_INFO'])[1];
$photo_id = explode('/',$_SERVER['PATH_INFO'])[2];
$result = $db->find('captions','id',$db->fixParameterUrl($id));
if(empty($result)){
    header('Location: ../index.php');
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
                                        <h4 class="page-title m-0">ویرایش کردن کپشن: <?php echo $result->title;?></h4>
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
                                    <form action="<?php echo '../../'.pathBackend(); ?>caption.php/<?php echo $result->id.'/'.$photo_id; ?>" method="post">
                                        <div class="form-group row">
                                            <label for="title" class="col-sm-2 col-form-label">عنوان</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" placeholder="عنوان" name="title" value="<?php echo $result->title; ?>" id="title">
                                                <div>
                                                    <?php echo errorInput('title'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-2 col-form-label">توضیحات</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control form-control-lg" placeholder="توضیحات" name="description" id="description" cols="30" rows="10"><?php echo $result->description; ?></textarea>
                                                <div> <?php echo errorInput('description'); ?></div>
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