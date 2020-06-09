<?php
    include('../../backEnd/functions/backEndFunctions/layouts/header.php');
    $db = new DB();
    $categories = $db->get('categories');
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
                                        <h4 class="page-title m-0">اضافه کردن تصویر جدید</h4>
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
                                    <form action="<?php echo pathBackend(); ?>gallery.php" method="POST" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label for="category_id" class="col-sm-2 col-form-label">برای دسته</label>
                                            <div class="col-sm-10">
                                                <select  class="form-control form-control-lg" name="category_id" id="category_id">
                                                    <option>---- انتخاب کنید ----</option>
                                                    <?php foreach ($categories as $category): ?>
                                                        <option value="<?php echo $category->id; ?>"><?php echo $category->title; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div>
                                                    <?php echo errorInput('category_id'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="images" class="col-sm-2 col-form-label">تصاویر</label>
                                            <div class="col-sm-10">
                                                <span style="color:red">حجم مجاز 6 مگابایت برای هر تصویر</span>
                                                <input class="form-control form-control-lg" multiple type="file" name="images[]" id="images">
                                                <div> <?php echo errorInput('images'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <?php
                                                    if(ACL::create())
                                                        echo '<button type="submit" name="create" id="submit" value="submit" class="col-sm-2 btn btn-success">ثبت</button>';
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