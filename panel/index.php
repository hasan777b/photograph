<?php include('../backEnd/functions/backEndFunctions/layouts/header.php');
$db = new DB();
$gallery = $db->get('gallery');
$user = $db->get('users',true);
$contacts = $db->get('contacts',true,'LIMIT 0,10');

?>
                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h4 class="page-title m-0">داشبرد</h4>
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
                                <div class="col-xl-6 col-md-6">
                                    <div class="card bg-primary mini-stat text-white">
                                        <div class="p-3 mini-stat-desc">
                                            <div class="clearfix">
                                                <h6 class="text-uppercase mt-0 float-left text-white-50">تعداد کاربران</h6>
                                                <h4 class="mb-3 mt-0 float-right"><?php echo count($user); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="col-xl-6 col-md-6">
                                    <div class="card bg-info mini-stat text-white">
                                        <div class="p-3 mini-stat-desc">
                                            <div class="clearfix">
                                                <h6 class="text-uppercase mt-0 float-left text-white-50">تعداد تصاویر</h6>
                                                <h4 class="mb-3 mt-0 float-right"><?php echo count($gallery); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->

                            <!-- end row -->

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title mb-4">اخرین تماس ها</h4>
                                            <div class="latest-massage">
                                                <?php foreach ($contacts as $contact): ?>
                                                <a href="contact/update.php/<?php echo $contact->id; ?>" class="latest-message-list">
                                                    <div class="border-bottom position-relative">
                                                        <div class="float-left user mr-3">
                                                            <h5 class="bg-primary text-center rounded-circle text-white mt-0">#</h5>
                                                        </div>
                                                        <div class="message-time">
                                                            <p class="m-0 text-muted">مشاهده</p>
                                                        </div>
                                                        <div class="massage-desc">
                                                            <h5 class="font-14 mt-0 text-dark"><?php echo $contact->username; ?></h5>
                                                            <p class="text-muted"><?php echo substr(nl2br(htmlspecialchars_decode($contact->message)),0,50) ?></p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <?php endforeach; ?>
                                            </div>
            
                                        </div>
                                    </div>
            
                                </div>
                            </div>
                            <!-- end row -->
                        </div><!-- container fluid -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->
<?php include('../backEnd/functions/backEndFunctions/layouts/footer_.php');?>