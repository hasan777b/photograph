<?php
    include('../../backEnd/functions/backEndFunctions/layouts/header.php');
    $db = new DB();
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $results = $db->paginate('services',true, ($page-1));
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
                                        <h4 class="page-title m-0">لیست سرویس ها</h4>
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
                                    <?php if(ACL::create()): ?>
                                        <a href="create.php" class="btn btn-success col-sm-1">اضافه کردن</a>
                                    <?php else: ?>
                                        <a onclick="alert('شما دسترسی این کار را ندارید')" class="btn btn-dark col-sm-1 errorAccess" disabled="disabled">اضافه کردن</a>
                                    <?php endif; ?>
                                    <br>
                                    <div class="text-center"><?php echo errorMessage(); ?></div>
                                    <br>

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>عنوان</th>
                                            <th>قیمت</th>
                                            <th>تصویر</th>
                                            <th>توضیحات</th>
                                            <th>ویرایش</th>
                                            <th>حذف</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <?php foreach ($results['results'] as $value): ?>
                                            <tr>
                                                <td><?php echo $value->title; ?></td>
                                                <td><?php echo number_format($value->price); ?></td>
                                                <td><img src="<?php echo '../../backEnd/'.$value->image; ?>" alt="<?php echo $value->title; ?>" width="120" height="120"></td>
                                                <td><?php echo substr(nl2br(htmlspecialchars_decode($value->description)),0,50);echo strlen($value->description) > 50 ? '...' : ''; ?></td>
                                                <td>
                                                <?php
                                                if(ACL::update())
                                                    echo '<a href="update.php/'.$value->id.'" class="btn btn-info"><i class="fa fa-edit"></i></a>';
                                                else
                                                    echo '<button onclick="alert(\'شما دسترسی لازم برای این کار را ندارید\')" class="col-sm-2 btn btn-dark errorAccess"><i class="fa fa-edit"></i></button>';
                                                ?>
                                                </td>
                                                <td>
                                                <?php if(ACL::delete()): ?>
                                                    <form action="<?php echo pathBackend(); ?>service.php/<?php echo $value->id; ?>" method="post">
                                                        <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('ایا از حذف این ایتم مطمعن هستید؟')"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                <?php else: ?>
                                                    <button onclick="alert('شما دسترسی لازم برای این کار را ندارید')" class="col-sm-2 btn btn-dark errorAccess"><i class="fa fa-trash"></i></button>;
                                                <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <div>
                                        <?php if(!empty($results['total_page']) and $results['total_page'] > 1){ echo renderPaginate($results['total_page'],$page);} ?>
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