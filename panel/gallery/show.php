<?php
include('../../backEnd/functions/backEndFunctions/layouts/header.php');
$db = new DB();
$category_id = $db->fixParameterUrl($_SERVER['PATH_INFO']);
$gallery = $db->find('gallery','category_id',$category_id, false);
$category = $db->find('categories','id',$category_id);
$_SESSION['imagePath'] = $_SERVER['PHP_SELF'];
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
                                        <h4 class="page-title m-0">نمایش تصاویر برای دسته <?php echo $category->title; ?></h4>
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
                                    <div><a href="../index.php" class="btn btn-purple">بازگشت</a></div>
                                    <div><?php echo errorMessage(); ?></div>
                                    <div class="row">
                                        <?php
                                            foreach ($gallery as $photo):
                                                $caption = $db->find('captions','photo_id',$photo->id);
                                        ?>
                                            <div class="col-lg-6">
                                                <div class="card m-b-30">
                                                    <div class="card-body">
                                                        <?php
                                                        if(ACL::update())
                                                            echo '<a href="../update.php/'.$photo->id.'" class="btn btn-info col-sm-2">ویرایش</a>';
                                                        else
                                                            echo '<button onclick="alert(\'شما دسترسی لازم برای این کار را ندارید\')" class="col-sm-2 btn btn-dark errorAccess">ویراش</button>';
                                                        ?>
                                                        <!--  Caption  -->
                                                            <?php
                                                                if(empty($caption)) {
                                                                    if (ACL::create()) {
                                                                        echo '<a href="../add_caption.php/' . $photo->id . '" class="btn btn-success">اضافه کردن کپشن</a>';
                                                                    } else {
                                                                        echo '<button onclick="alert(\'شما دسترسی لازم برای این کار را ندارید\')" class="col-sm-2 btn btn-dark errorAccess">اضافه کردن کپشن</button>';
                                                                    }
                                                                } else{
                                                                    if(ACL::update()){
                                                                        echo '<a href="../update_caption.php/'.$caption->id.'/'.$photo->id.'" class="btn btn-primary">ویرایش کردن کپشن</a>';
                                                                    }else{
                                                                        echo '<button onclick="alert(\'شما دسترسی لازم برای این کار را ندارید\')" class="col-sm-2 btn btn-dark errorAccess">ویرایش کردن کپشن</button>';
                                                                    }
                                                                }

                                                            ?>
                                                        <!-- End Caption  -->
                                                        <br><br>
                                                        <div class="">
                                                            <img src="<?php echo '../../../backEnd/'.$photo->image; ?>" class="img-fluid" alt="<?php echo $category->title; ?>" style="width: 500px;height: 400px;">
                                                        </div>
                                                        <?php
                                                            if(!empty($caption)){
                                                                echo '<div style="margin-top:15px;font-size: 18px;">';
                                                                echo '<span>کپشن: '.$caption->title.'</span><br>';
                                                                echo '<span>توضیحات: '.nl2br(htmlspecialchars_decode($caption->description)).'</span></div>';
                                                                if(ACL::delete()){
                                                                    echo '<br><form action="../'.pathBackend().'caption.php/'.$caption->id.'/'.$photo->category_id.'" method="post">';
                                                                    echo '   <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm(\'ایا از حذف این ایتم مطمعن هستید؟\')"> حذف کپشن </button>';
                                                                    echo '</form>';
                                                                }else{
                                                                    echo '<button onclick="alert(\'شما دسترسی لازم برای این کار را ندارید\')" class="col-sm-2 btn btn-dark errorAccess">حذف کپشن</button>';
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php include('../../backEnd/functions/backEndFunctions/layouts/footer_.php');?>