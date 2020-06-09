<?php include('../../backEnd/functions/backEndFunctions/layouts/header.php');
    $db = new DB();
    $result = $db->find('contacts','id',$db->fixParameterUrl($_SERVER['PATH_INFO']));
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
                                        <h4 class="page-title m-0">پاسخ به پیام:<?php echo $result->username;?></h4>
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
                                    <form action="<?php echo '../'.pathBackend(); ?>contact.php/<?php echo $result->id; ?>" method="post">
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">ایمیل</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-lg" type="text" name="email" disabled value="<?php echo $result->email; ?>" id="email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="message" class="col-sm-2 col-form-label">پیام</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control form-control-lg" disabled placeholder="پیام" id="message" cols="30" rows="10"><?php echo $result->message; ?></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <label for="answer" class="col-sm-2 col-form-label">پاسخ شما</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control form-control-lg" name="answer" placeholder="پاسخ شما" id="answer" cols="30" rows="10"></textarea>
                                                <div> <?php echo errorInput('answer'); ?></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <?php
                                                if(ACL::update())
                                                    echo '<button type="submit" name="update" value="submit" class="col-sm-2 btn btn-success">ارسال</button>';
                                                else
                                                    echo '<button onclick="alert(\'شما دسترسی لازم برای این کار را ندارید\')" class="col-sm-2 btn btn-dark errorAccess">ارسال</button>';
                                                ?>
                                                <a href="../index.php" class="col-sm-2 btn btn-danger">برگشت</a>
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