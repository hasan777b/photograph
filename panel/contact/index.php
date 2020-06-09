<?php
    include('../../backEnd/functions/backEndFunctions/layouts/header.php');
    $db = new DB();
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $results = $db->paginate('contacts',true, ($page-1));
    $notifications = $db->find('notifications','type','contacts',false);
    foreach ($notifications as $notification){
        if(is_null($notification->read_at)) {
            $db->update('notifications', ['read_at'], ['id' => $notification->id, 'read_at' => Date('Y-m-d H:i:s')]);
        }
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
                                        <h4 class="page-title m-0">لیست تماس ها</h4>
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
                                    <div class="text-center"><?php echo errorMessage(); ?></div>
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>نام</th>
                                            <th>نام خانوادگی</th>
                                            <th>ایمیل</th>
                                            <th>موضوع</th>
                                            <th>پیام</th>
                                            <th>پاسخ</th>
                                            <th>پاسخ شما</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <?php foreach ($results['results'] as $value): ?>
                                            <tr>
                                                <td><?php echo $value->username; ?></td>
                                                <td><?php echo $value->lastname; ?></td>
                                                <td><?php echo $value->email; ?></td>
                                                <td><?php echo $value->subject; ?></td>
                                                <td><?php echo substr(nl2br(htmlspecialchars_decode($value->message)),0,50);echo strlen($value->message) > 50 ? '...' : ''; ?></td>
                                                <td>
                                                <?php
                                                if(ACL::update())
                                                    echo '<a href="update.php/'.$value->id.'" class="btn btn-info"><i class="fa fa-reply"></i></a>';
                                                else
                                                    echo '<button onclick="alert(\'شما دسترسی لازم برای این کار را ندارید\')" class="col-sm-2 btn btn-dark errorAccess"><i class="fa fa-reply"></i></button>';
                                                ?>
                                                </td>
                                                <td><?php if(!empty($value->answer)){
                                                        echo substr(nl2br(htmlspecialchars_decode($value->answer)),0,50);echo strlen($value->answer) > 50 ? '...' : '';}
                                                    else{echo 'پاسخی ارسال نشده است';}
                                                    ?>
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