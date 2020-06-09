<?php include("backEnd/functions/frontFunctions/layouts/header.php");
$db = new DB();
$slug = $db->fixParameterUrl($_SERVER['PATH_INFO'],'string');
$category = $db->find('categories','slug',$slug);
$images = $db->find('gallery','category_id',$category->id,false)
?>
  <div class="site-section"  data-aos="fade">
    <div class="container-fluid">
      
      <div class="row justify-content-center">
        
        <div class="col-md-7">
          <div class="row mb-5">
            <div class="col-12 ">
              <h2 class="site-section-heading text-center"><?php echo $category->title; ?></h2>
            </div>
          </div>
        </div>
    
      </div>
      <div class="row" id="lightgallery">
        <?php foreach ($images as $image):
            $caption = $db->find('captions','photo_id', $image->id);
        ?>
            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 item" data-aos="fade" data-src="<?php echo pathImage($image->image); ?>" data-sub-html="<h4><?php echo !empty($caption) ? $caption->title : '' ?></h4><p><?php echo !empty($caption) ? nl2br(htmlspecialchars_decode($caption->description)) : ''; ?></p>">
          <a href="#"><img src="<?php echo pathImage($image->image); ?>" alt="IMage" class="img-fluid" style="width: 194px;height: 140px;"></a>
        </div>
        <?php endforeach;; ?>
      </div>
    </div>
  </div>
  <?php include("backEnd/functions/frontFunctions/layouts/footer.php");?>