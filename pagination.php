<div class="post-navigation">

	<?php
	global $wp_query;

	$big = 999999999; // need an unlikely integer
	$translated = __( 'Page', 'mytextdomain' ); // Supply translatable string

	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
	  'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>'
	) );


	// 	'base'               => '%_%',
	// 	'format'             => '?page=%#%',
	// 	'total'              => 1,
	// 	'current'            => 0,
	// 	'show_all'           => False,
	// 	'end_size'           => 1,
	// 	'mid_size'           => 2,
	// 	'prev_next'          => True,
	// 	'prev_text'          => __('« Previous'),
	// 	'next_text'          => __('Next »'),
	// 	'type'               => 'plain',
	// 	'add_args'           => False,
	// 	'add_fragment'       => '',
	// 	'before_page_number' => '',
	// 	'after_page_number'  => ''


	?>

</div>
