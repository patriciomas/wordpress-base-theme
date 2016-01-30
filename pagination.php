<div class="post-navigation">
  <div class="divisor"></div>
  <?php if ( !is_archive() && !is_search() ) { ?>
    <div class="nav-previous"><?php previous_post_link(); ?></div>
    <div class="nav-next"><?php next_post_link(); ?></div>
  <?php }else{
    the_posts_pagination( array(
    	'mid_size'  => 2,
      'prev_text' => __( '<i class="fa fa-chevron-left"></i>' ),
      'next_text' => __( '<i class="fa fa-chevron-right"></i>' ),
      ) );
  }; ?>
</div>
