<?php include('../../backEnd/functions/backEndFunctions/layouts/header.php');
    $db = new DB();
    $result = $db->find('categories','id',$db->fixParameterUrl($_SERVER['PATH_INFO']));
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
                                        <h4 class="page-title m-0">ویرایش کردن دسته بندی:<?php echo $result->title;?></h4>
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
                                    <form action="<?php echo '../'.pathBackend(); ?>category.php/<?php echo $result->id; ?>" method="post">
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
                                            <label for="position" class="col-sm-2 col-form-label">مکان</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="number" min="1" placeholder="مکان" name="position" value="<?php echo $result->position; ?>" id="position">
                                                <div> <?php echo errorInput('position'); ?></div>
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
                                                <a href="../category.php" class="col-sm-2 btn btn-danger">برگشت</a>
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