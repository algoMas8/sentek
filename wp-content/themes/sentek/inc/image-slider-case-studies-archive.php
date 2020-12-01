<!-- image carousel -->
<?php // need to pass the ID of the blog archive for it to work

  if(have_rows('slider', 20148)){ ?>

    <div class="home-carousel-wrapper">

        <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="1000">

          <div class="carousel-inner">

            <?php while(has_sub_field('slider', 20148)): ?>

              <div class="carousel-item" style="background-image: url('<?php the_sub_field('image', 20148); ?>')">
              </div><!--carousel-item-->

            <?php endwhile; ?>

          </div>



        </div>

            <a class="carousel-control-prev slider-arrow" href="#carousel" role="button" data-slide="prev">

              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next slider-arrow" href="#carousel" role="button" data-slide="next">

              <span class="sr-only">Next</span>
            </a>

          </div>




<?php } ?> <!-- close if has carousel -->

<!-- BS4 image carousel hacks-->
<script>
jQuery('div.carousel-inner div:first-child').addClass('active');
</script>
