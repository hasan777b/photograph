<?php
    include('../../backEnd/functions/backEndFunctions/layouts/header.php');
    $db = new DB();
    $results = $db->get('abouts');
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
                                        <h4 class="page-title m-0">درباره ما</h4>
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
                                    <?php if(count($results) == 0){ if(ACL::create()): ?>
                                        <a href="create.php" class="btn btn-success col-sm-1">اضافه کردن</a>
                                    <?php else: ?>
                                        <a onclick="alert('شما دسترسی این کار را ندارید')" class="btn btn-dark col-sm-1 errorAccess" disabled="disabled">اضافه کردن</a>
                                    <?php endif; }?>
                                    <br>
                                    <div class="text-center"><?php echo errorMessage(); ?></div>
                                    <br>

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>تصویر</th>
                                            <th>توضیحات</th>
                                            <th>ویرایش</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <?php foreach ($results as $value): ?>
                                            <tr>
                                                <td><img src="<?php echo '../../backEnd/'.$value->image ?>" alt="about" width="120" height="120"></td>
                                                <td><?php echo substr(nl2br(htmlspecialchars_decode($value->description)),0,50);echo strlen($value->description) > 50 ? '...' : ''; ?></td>
                                                <td>
                                                <?php
                                                if(ACL::update())
                                                    echo '<a href="update.php/'.$value->id.'" class="btn btn-info"><i class="fa fa-edit"></i></a>';
                                                else
                                                    echo '<button onclick="alert(\'شما دسترسی لازم برای این کار را ندارید\')" class="col-sm-2 btn btn-dark errorAccess"><i class="fa fa-edit"></i></button>';
                                                ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php include('../../backEnd/functions/backEndFunctions/layouts/footer_.php');?>