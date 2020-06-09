<?php include("backEnd/functions/frontFunctions/layouts/header.php");
$db = new DB();
$services = $db->get('services');

?>

  <div class="site-section"  data-aos="fade">
    <div class="container-fluid">
      
      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="row mb-5">
            <div class="col-12 ">
              <h2 class="site-section-heading text-center">دیگر سرویس ها</h2>
            </div>
          </div>
          <div class="row">
              <?php foreach ($services as $service): ?>
                <div class="col-md-6 col-lg-6 col-xl-4 text-center mb-5 mb-lg-5">
              <div class="h-100 p-4 p-lg-5 bg-light site-block-feature-7">
                <span class="display-3 text-primary mb-4 d-block"><img src="<?php echo pathImage($service->image); ?>" alt="<?php echo $service->title; ?>" width="150" height="180"></span>
                <h3 class="text-black h4"><?php echo $service->title; ?></h3>
                <p><?php echo nl2br(htmlspecialchars_decode($service->description)); ?></p>
                <p><strong class="font-weight-bold text-primary"><?php echo number_format($service->price); ?> تومان </strong></p>
              </div>
            </div>
              <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include("backEnd/functions/frontFunctions/layouts/footer.php");?>