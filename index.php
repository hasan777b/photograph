<?php include("backEnd/functions/frontFunctions/layouts/header.php");
$db = new DB();
$gallery = $db->get('gallery',true,'LIMIT 0,15','GROUP BY `category_id`');
?>
  <div class="container-fluid" data-aos="fade" data-aos-delay="500">
    <div class="swiper-container images-carousel">
        <div class="swiper-wrapper">
            <?php foreach ($gallery as $image):
                $category = $db->find('categories','id',$image->category_id);
            ?>
                <div class="swiper-slide">
              <div class="image-wrap">
                <div class="image-info">
                  <h2 class="mb-3"><?php echo $category->title ?></h2>
                  <a href="single.php/<?php echo $category->slug; ?>" class="btn btn-outline-white py-2 px-4">بیشتر</a>
                </div>
                <img src="<?php echo pathImage($image->image); ?>" alt="Image">
              </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-scrollbar"></div>
    </div>
  </div>
<?php include("backEnd/functions/frontFunctions/layouts/footer.php");?>
