<?php
    include('../../backEnd/functions/backEndFunctions/layouts/header.php');
    $db = new DB();
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $results = $db->paginate('gallery',true, ($page-1), 10,'group By `category_id` DESC ');
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
                                        <h4 class="page-title m-0">لیست تصاویر</h4>
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
                                            <th>برای دسته</th>
                                            <th>تصویر</th>
                                            <th>نمایش</th>
                                            <th>حذف</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <?php foreach ($results['results'] as $value): ?>
                                            <tr>
                                                <td><?php $category = $db->find('categories','id',$value->category_id); echo $category->title; ?></td>
                                                <td><img src="<?php echo '../../BackEnd/'.$value->image; ?>" alt="<?php echo $category->title; ?>" width="120" height="120"></td>
                                                <td><a href="show.php/<?php echo $value->category_id; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                                                <td>
                                                <?php if(ACL::delete()): ?>
                                                    <form action="<?php echo pathBackend(); ?>gallery.php/<?php echo $value->category_id; ?>" method="post">
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