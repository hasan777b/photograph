<?php include("backEnd/functions/frontFunctions/layouts/header.php");
$db = new DB();
$about = $db->getOneRow('abouts');
$partners = $db->get('partners');

?>

  <div class=""  data-aos="fade">
    <div class="container-fluid">
      
      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="row mb-5 site-section">
            <div class="col-12 ">
              <h2 class="site-section-heading text-center">درباره ما</h2>
            </div>
          </div>

          <div class="row mb-5">
            <div class="col-md-7">
              <img src="<?php echo pathImage($about->image); ?>" alt="Images" class="img-fluid" style="width: 440px; height: 500px;">
            </div>
            <div class="col-md-4 ml-auto">
              <p><?php echo nl2br(htmlspecialchars_decode($about->description)); ?></p>
            </div>
          </div>

         
          <div class="row site-section">
              <?php foreach ($partners as $partner): ?>
                <div class="col-md-6 col-lg-6 col-xl-4 text-center mb-5">
                  <img src="<?php echo pathImage($partner->image); ?>" alt="Image" class="img-fluid w-50 rounded-circle mb-4">
                  <h2 class="text-black font-weight-light mb-4"><?php echo $partner->username; ?></h2>
                  <p class="mb-4"><?php echo nl2br(htmlspecialchars_decode($partner->bio)); ?></p>
                  <p>
                    <a href="<?php echo !empty($partner->twitter) ? $partner->twitter : ''; ?>" class="pl-0 pr-3"><span class="icon-twitter"></span></a>
                    <a href="<?php echo !empty($partner->instagram) ? $partner->instagram : ''; ?>" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                    <a href="<?php echo !empty($partner->facebook) ? $partner->facebook : ''; ?>" class="pl-3 pr-3"><span class="icon-facebook"></span></a>
                  </p>
                </div>
              <?php endforeach; ?>
          </div>
        </div>
    
      </div>
    </div>
  </div>
<?php include("backEnd/functions/frontFunctions/layouts/footer.php");?>