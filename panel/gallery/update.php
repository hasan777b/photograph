<?php include('../../backEnd/functions/backEndFunctions/layouts/header.php');
    $db = new DB();
    $result = $db->find('gallery','id',$db->fixParameterUrl($_SERVER['PATH_INFO']));
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
                                        <h4 class="page-title m-0">ویرایش کردن تصویر</h4>
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
                                    <form action="<?php echo '../'.pathBackend(); ?>gallery.php/<?php echo $result->id; ?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label for="category_id" class="col-sm-2 col-form-label">برای دسته</label>
                                            <div class="col-sm-10">
                                                <select  class="form-control form-control-lg" name="category_id" id="category_id">
                                                    <?php foreach ($categories as $category):
                                                        $title = '';
                                                        if($category->id == $result->category_id)
                                                            $title = $category->title;
                                                    ?>
                                                        <option value="<?php echo $category->id;?>" <?php echo !empty($title) ? 'selected' : ''; ?>><?php echo $category->title; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div>
                                                    <?php echo errorInput('category_id'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="image" class="col-sm-2 col-form-label">تصویر</label>
                                            <div class="col-sm-10">
                                                <span style="color:red">حجم مجاز 6 مگابایت</span>
                                                <input class="form-control form-control-lg" type="file" name="image" id="image">
                                                <div> <?php echo errorInput('image'); ?></div>
                                                <div><img src="<?php echo '../../../backEnd/'.$result->image; ?>" alt="<?php echo $title; ?>" width="120" height="120"></div>
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
                                                <a href="../show.php/<?php echo $result->category_id; ?>" class="col-sm-2 btn btn-danger">برگشت</a>
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