<?php

// Hide admin bar in frontend
show_admin_bar( false );

/* Remove WordPress version from header for security */
remove_action('wp_head', 'wp_generator');

/* Remove login errors for security */
add_filter('login_errors', create_function('$a', "return null;"));

/* Register the widget columns */
    if ( function_exists('register_sidebar') ){
		register_sidebar(Array(
		'name' => 'Sidebar',
		'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
		));
    };

/* Get category ID by name */
function get_category_id($cat_name){
	$term = get_term_by('name', $cat_name, 'category');
	return $term->term_id;
}

// Add Featured Image Support
add_theme_support( 'post-thumbnails' );

/* Custom Menu */
add_action('init', 'register_custom_menu');

function register_custom_menu() {
register_nav_menu('main_menu', __('Main Menu'));
}

function add_first_and_last($output) {
  $output = preg_replace('/class="menu-item/', 'class="first-menu-item menu-item', $output, 1);
  $output = substr_replace($output, 'class="last-menu-item menu-item', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
  return $output;
}
add_filter('wp_nav_menu', 'add_first_and_last');


/* Dimox Breadcrumbs * http://dimox.net/wordpress-breadcrumbs-without-a-plugin/ */
function the_breadcrumb(){
  /* === OPTIONS === */
	$text['home']     = __('Home'); // text for the 'Home' link
	$text['category'] = __('Archive by Category "%s"'); // text for a category page
	$text['tax'] 	  = __('Archive for "%s"'); // text for a taxonomy page
	$text['search']   = __('Search Results for "%s"'); // text for a search results page
	$text['tag']      = __('Posts Tagged "%s"'); // text for a tag page
	$text['author']   = __('Articles Posted by %s'); // text for an author page
	$text['404']      = __('Error 404'); // text for the 404 page
	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter   = ' &raquo; '; // delimiter between crumbs
	$before      = '<span class="current">'; // tag before the current crumb
	$after       = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */
	global $post;
	$homeLink = get_bloginfo('url') . '/';
	$linkBefore = '<span typeof="v:Breadcrumb">';
	$linkAfter = '</span>';
	$linkAttr = ' rel="v:url" property="v:title"';
	$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
	if (is_home() || is_front_page()) {
		if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';
	} else {
		echo '<div id="crumbs">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

		if ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
		} elseif( is_tax() ){
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['tax'], single_cat_title('', false)) . $after;

		}elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;
		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;
		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;
		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;
		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			}
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
			$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
			echo $cats;
			printf($link, get_permalink($parent), $parent->post_title);
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
		} elseif ( is_page() && !$post->post_parent ) {
			if ($showCurrent == 1) echo $before . get_the_title() . $after;
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo $delimiter;
			}
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
		} elseif ( is_tag() ) {
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;
		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		}
		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __('Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}
		echo '</div>';
	}
} // end dimox_breadcrumbs()


// Cortar n�mero de palabras
function string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}
// Cortar n�mero de palabras

/* +++ Custom Login Logo +++ */
add_action('login_head', 'my_custom_login_logo');

function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/css/images/login-logo.png) !important; }
    </style>';
}
/* +++ Custom Login Logo +++ */


/* +++ Custom Admin Logo +++ */
add_action('admin_head', 'my_custom_logo');

function my_custom_logo() {
   echo '
      <style type="text/css">
        #header-logo { background-image: url('.get_bloginfo('template_directory').'/css/images/admin-logo.png) !important; width:200px; }
		#wphead { background:#FFF; !important }
      </style>
   ';
}
/* +++ Custom Admin Logo +++ */

/* +++ Funciones para el extracto +++ */

// Para extender el m�ximo de 55 palabras
function pixelkit_excerpt_length($length) {
	return 100;
}
add_filter('excerpt_length', 'pixelkit_excerpt_length');

// Para cambiar el [...] que viene por defecto
function new_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'new_excerpt_more');
/* +++ Funciones para el extracto +++ */


// Social Sharing Buttons
function social_sharing_buttons() {

		// Get current page URL
		$shareURL = get_permalink();

		// Get current page title
		$shareTitle = str_replace( ' ', '%20', get_the_title());

		// Get Post Thumbnail for pinterest
		$shareThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

		// Construct sharing URL without using any script
		$twitterURL = 'https://twitter.com/intent/tweet?text='.$shareTitle.'&amp;url='.$shareURL.'&amp;via=Crunchify';
		$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$shareURL;
		$googleURL = 'https://plus.google.com/share?url='.$shareURL;
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$shareURL.'&amp;media='.$shareThumbnail[0].'&amp;description='.$shareTitle;

		// Add sharing button at the end of page/page content
		$buttonsContent .= '<ul class="social-links">';
		$buttonsContent .= '<li class="twitter"><a href="'. $twitterURL .'" target="_blank"><span class="fa-stack fa-lg">
      <i class="fa fa-circle fa-stack-2x"></i>
      <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
    </span></a></li>';
		$buttonsContent .= '<li class="facebook"><a href="'.$facebookURL.'" target="_blank"><span class="fa-stack fa-lg">
      <i class="fa fa-circle fa-stack-2x"></i>
      <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
    </span></a></li>';
		$buttonsContent .= '<li class="google-plus"><a href="'.$googleURL.'" target="_blank"><span class="fa-stack fa-lg">
      <i class="fa fa-circle fa-stack-2x"></i>
      <i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
    </span></a></li>';
		$buttonsContent .= '<li class="pinterest"><a href="'.$pinterestURL.'" target="_blank"><span class="fa-stack fa-lg">
      <i class="fa fa-circle fa-stack-2x"></i>
      <i class="fa fa-pinterest fa-stack-1x fa-inverse"></i>
    </span></a></li>';
		$buttonsContent .= '</ul>';

		echo $buttonsContent;

};



/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
function pk_customizer( $wp_customize ) {

	$wp_customize->remove_section('static_front_page');

	// SECCI�N OPCIONES GENERALES
    $wp_customize->add_section(
        'general_options',
        array(
            'title' => 'Opciones Generales',
            'description' => 'Para que algunos de estos contenidos se muestren en los diferentes idiomas, los textos se deben separar con este tipo de etiquetas: <code>&lt;!--:es--&gt;</code> ... <code>&lt;!--:--&gt;</code> .<br>
            Se puede copiar y pegar este ejemplo como base:<br>
			<code>&lt;!--:es--&gt;Espa&ntilde;ol&lt;!--:--&gt;&lt;!--:en--&gt;English&lt;!--:--&gt;&lt;!--:pt--&gt;Portuegu&ecirc;s&lt;!--:--&gt;</code>',
            'priority' => '35',
        )
    );
    // IDIOMAS
	$wp_customize->add_setting(
		'hide_language_options'
	);
	$wp_customize->add_control(
	    'hide_language_options',
	    array(
	        'type' => 'checkbox',
	        'label' => 'Esconder opciones de idiomas',
	        'section' => 'general_options',
            'priority' => '1',
	    )
	);
	// SLOGAN
	$wp_customize->add_setting(
	    'slogan',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'slogan',
	    array(
	        'label' => 'Slogan',
	        'section' => 'general_options',
	        'type' => 'text',
            'priority' => '2',
	    )
	);
	// CONTENIDO ERROR404
	$wp_customize->add_setting(
	    'ID404',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'ID404',
	    array(
	        'label' => 'ID P&aacute;gina Error 404',
	        'section' => 'general_options',
	        'type' => 'text',
            'priority' => '3',
	    )
	);

	// SECCI�N REDES SOCIALES
    $wp_customize->add_section(
        'social_options',
        array(
            'title' => 'Redes Sociales',
            'description' => 'Inserte aqu&iacute; las direcciones web de las redes disponibles. Deje en blanco para deshabilitar.',
            'priority' => '36',
        )
    );
	// FACEBOOK
	$wp_customize->add_setting(
	    'url_facebook',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url_facebook',
	    array(
	        'label' => 'URL Facebook',
	        'section' => 'social_options',
	        'type' => 'text',
            'priority' => '1',
	    )
	);
	// TWITTER
	$wp_customize->add_setting(
	    'url_twitter',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url_twitter',
	    array(
	        'label' => 'URL Twitter',
	        'section' => 'social_options',
	        'type' => 'text',
            'priority' => '2',
	    )
	);
	// LINKEDIN
	$wp_customize->add_setting(
	    'url_linkedin',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url_linkedin',
	    array(
	        'label' => 'URL Linkedin',
	        'section' => 'social_options',
	        'type' => 'text',
            'priority' => '3',
	    )
	);

	// SECCI�N PORTADA
    $wp_customize->add_section(
        'homepage_options',
        array(
            'title' => 'Portada',
            'description' => 'T&iacute;tulos, textos y links en la portada.',
            'priority' => '37',
        )
    );
	// TITULO SERVICIOS
	$wp_customize->add_setting(
	    'soluciones-titulo',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'soluciones-titulo',
	    array(
	        'label' => 'T&iacute;tulo Secci&oacute;n Servicios',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '1',
	    )
	);
	// TEXTO SERVICIOS
	class Custom_Textarea_Control extends WP_Customize_Control {
	    public $type = 'textarea';

	    public function render_content() {
	        ?>
	        <label>
	        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	        <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	        </label>
	        <?php
	    }
	}
	$wp_customize->add_setting(
		'soluciones-parrafo',
		array(
	    	'default' => '',
		)
	);

	$wp_customize->add_control(
		new Custom_Textarea_Control(
		$wp_customize, 'soluciones-parrafo',
			array(
			    'label' => 'Texto descripci&oacute;n Servicios',
			    'section' => 'homepage_options',
			    'settings' => 'soluciones-parrafo',
		        'priority' => '2',
			)
		)
	);
	// TITULO BOTON 1
	$wp_customize->add_setting(
	    'titulo-caluga-1',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'titulo-caluga-1',
	    array(
	        'label' => 'T&iacute;tulo Bot&oacute;n 1',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '3',
	    )
	);
	// URL BOTON 1
	$wp_customize->add_setting(
	    'url-boton-caluga-1',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url-boton-caluga-1',
	    array(
	        'label' => 'URL Bot&oacute;n 1',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '4',
	    )
	);
	// TITULO BOTON 2
	$wp_customize->add_setting(
	    'titulo-caluga-2',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'titulo-caluga-2',
	    array(
	        'label' => 'T&iacute;tulo Bot&oacute;n 2',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '5',
	    )
	);
	// URL BOTON 2
	$wp_customize->add_setting(
	    'url-boton-caluga-2',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url-boton-caluga-2',
	    array(
	        'label' => 'URL Bot&oacute;n 2',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '6',
	    )
	);
	// TITULO BOTON 3
	$wp_customize->add_setting(
	    'titulo-caluga-3',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'titulo-caluga-3',
	    array(
	        'label' => 'T&iacute;tulo Bot&oacute;n 3',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '7',
	    )
	);
	// URL BOTON 3
	$wp_customize->add_setting(
	    'url-boton-caluga-3',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url-boton-caluga-3',
	    array(
	        'label' => 'URL Bot&oacute;n 3',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '8',
	    )
	);
	// TITULO BOTON 4
	$wp_customize->add_setting(
	    'titulo-caluga-4',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'titulo-caluga-4',
	    array(
	        'label' => 'T&iacute;tulo Bot&oacute;n 4',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '9',
	    )
	);
	// URL BOTON 4
	$wp_customize->add_setting(
	    'url-boton-caluga-4',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'url-boton-caluga-4',
	    array(
	        'label' => 'URL Bot&oacute;n 4',
	        'section' => 'homepage_options',
	        'type' => 'text',
	        'priority' => '10',
	    )
	);
	// TITULO DESTACADOS
	$wp_customize->add_setting(
	    'titulo-destacados',
	    array(
	        'default' => '',
	    )
	);
	$wp_customize->add_control(
    	'titulo-destacados',
	    array(
	        'label' => 'T&iacute;tulo Art&iacute;culos Destacados',
	        'section' => 'homepage_options',
	        'type' => 'text',
            'priority' => '11',
	    )
	);


}

add_action( 'customize_register', 'pk_customizer' );


// Custom Comments

function mytheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
  	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    	<?php endif; ?>
    	<div class="comment-author vcard">
    	<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    	<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
    	</div>
    	<?php if ( $comment->comment_approved == '0' ) : ?>
    		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
    		<br />
    	<?php endif; ?>

    	<div class="comment-meta commentmetadata">
    		<?php
    			/* translators: 1: date, 2: time */
    			printf( __('%1$s %2$s'), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( __( 'Edit' ), ' | ', '' );
    		?>
    	</div>

    	<?php comment_text(); ?>

    	<div class="reply">
    	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    	</div>

    	<?php if ( 'div' != $args['style'] ) : ?>
  	</div>
	<?php endif; ?>
<?php
};


//END ?>
