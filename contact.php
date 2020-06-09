<?php include("backEnd/functions/frontFunctions/layouts/header.php");
$config = config();
?>


<div class="site-section" data-aos="fade">
    <div class="container-fluid">
      
      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="row mb-5">
            <div class="col-12 ">
              <h2 class="site-section-heading text-center">تماس با ما</h2>
                <div class="text-center"><?php echo errorMessage() ?></div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-8 mb-5">
              <form action="backEnd/functions/backEndFunctions/contact.php" method="post">
                <div class="row form-group">
                  <div class="col-md-6 mb-3 mb-md-0">
                    <label class="text-black" for="username">نام</label>
                    <input type="text" id="username" name="username" class="form-control">
                      <div> <?php echo errorInput('username'); ?></div>
                  </div>
                  <div class="col-md-6">
                    <label class="text-black" for="lastname">نام خانوادگی</label>
                    <input type="text" id="lastname" name="lastname" class="form-control">
                    <div> <?php echo errorInput('lastname'); ?></div>
                  </div>
                </div>

                <div class="row form-group">
                  
                  <div class="col-md-12">
                    <label class="text-black" for="email">ایمیل</label>
                    <input type="email" id="email" name="email" class="form-control">
                    <div> <?php echo errorInput('email'); ?></div>
                  </div>
                </div>

                <div class="row form-group">
                  
                  <div class="col-md-12">
                    <label class="text-black" for="subject">موضوع</label>
                    <input type="subject" id="subject" name="subject" class="form-control">
                    <div> <?php echo errorInput('subject'); ?></div>
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col-md-12">
                    <label class="text-black" for="message">پیام</label>
                    <textarea name="message" id="message" cols="30" rows="7" class="form-control" placeholder="...نظر یا سوال خود را اینجا بنویسید"></textarea>
                      <div> <?php echo errorInput('message'); ?></div>
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col-md-12">
                    <input type="submit" name="contact" value="ارسال" class="btn btn-primary py-2 px-4 text-white">
                  </div>
                </div>

    
              </form>
            </div>
            <div class="col-lg-3 ml-auto">
              <div class="mb-3 bg-white">
                <p class="mb-0 font-weight-bold">ادرس</p>
                <p class="mb-4"><?php echo $config->address; ?></p>

                <p class="mb-0 font-weight-bold">تلفن</p>
                <p class="mb-4"><a href=""><?php echo $config->phone; ?></a></p>

                <p class="mb-0 font-weight-bold">ادرس ایمیل</p>
                <p class="mb-0"><a href=""><?php echo $config->email; ?></a></p>

              </div>
              
            </div>
          </div>
        </div>
    
      </div>
    </div>
  </div>
<?php include("backEnd/functions/frontFunctions/layouts/footer.php");?>