<!-- image carousel -->
<?php

  if(have_rows('slider')){ ?>

    <div class="home-carousel-wrapper">

        <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="1000">

          <div class="carousel-inner">

            <?php while(has_sub_field('slider')): ?>

              <div class="carousel-item" style="background-image: url('<?php the_sub_field('image'); ?>')">
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
