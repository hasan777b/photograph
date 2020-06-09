<?php
    include('../../backEnd/functions/backEndFunctions/layouts/header.php');
    $db = new DB();
    $result = $db->get('config');
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
                                        <h4 class="page-title m-0">لیست کانفیگ سایت</h4>
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
                                    <?php if(empty($result)){ if(ACL::manager()): ?>
                                        <a href="create.php" class="btn btn-success col-sm-1">اضافه کردن</a>
                                    <?php else: ?>
                                        <a onclick="alert('شما دسترسی این کار را ندارید')" class="btn btn-dark col-sm-1 errorAccess" disabled="disabled">اضافه کردن</a>
                                    <?php endif; }?>
                                    <br>
                                    <div class="text-center"><?php echo errorMessage(); ?></div>
                                    <br>

                                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>موبایل</th>
                                            <th>ایمیل</th>
                                            <th>ادرس</th>
                                            <th>اینستاکرام</th>
                                            <th>تویتر</th>
                                            <th>فیسبوک</th>
                                            <th>یوتیوب</th>
                                            <th>فوتر</th>
                                            <th>لوگو</th>
                                            <th>ویرایش</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <?php foreach ($result as $value): ?>
                                            <tr>
                                                <td><?php echo $value->phone; ?></td>
                                                <td><?php echo $value->email; ?></td>
                                                <td><?php echo $value->address; ?></td>
                                                <td><?php echo empty($value->instagram) ? 'ثبت نشده است' : $value->instagram; ?></td>
                                                <td><?php echo empty($value->twitter) ? 'ثبت نشده است' : $value->twitter; ?></td>
                                                <td><?php echo empty($value->facebook) ? 'ثبت نشده است' : $value->facebook; ?></td>
                                                <td><?php echo empty($value->youtube) ? 'ثبت نشده است' : $value->youtube; ?></td>
                                                <td><?php echo $value->footer; ?></td>
                                                <td><img src="../../backEnd/<?php echo $value->logo; ?>" alt="logo" width="120" height="120"></td>
                                                <td>
                                                <?php
                                                if(ACL::manager())
                                                    echo '<a href="update.php/'.$value->id.'" class="btn btn-info"><i class="fa fa-edit"></i></a>';
                                                else
                                                    echo '<button onclick="alert(\'شما دسترسی لازم برای این کار را ندارید\')" class="col-sm-2 btn btn-dark errorAccess"><i class="fa fa-edit"></i></button>';
                                                ?>
                                                </td>
                                                <td>
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