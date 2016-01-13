<?php

// establish the global $post varaiable
global $post;
// id of 'page not found' wordpress page
$page_id = get_theme_mod('ID404');
// get the page data, must assign to the global $post variable
$post = get_post($page_id);
// set up the global $post object
setup_postdata($post);

?>

	<h1><?php the_title(); ?></h1>
	
	<?php the_content(); ?>
