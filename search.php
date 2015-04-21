<?php get_header(); ?>

	<main id="content" class="search">
	
	<?php include(TEMPLATEPATH."/breadcrumb.php");?>

	<?php if (have_posts()) : ?>
	
	<h2><?php echo('Resultados de "' . get_search_query() . '"'  ); ?></h2>
	
	<?php if(function_exists('wp_paginate')) {
		wp_paginate();
	} ?>
	
	<div class="caja archive">

	<?php while (have_posts()) : the_post(); ?>

			<div class="box">
				<div class="extracto">
					<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
					<?php echo the_excerpt(); ?>
				</div>
			</div>

			<?php endwhile; ?>
			
	</div><!-- caja-archive -->

	<?php if(function_exists('wp_paginate')) {
		wp_paginate();
	} ?>

	<?php else : ?>
	
	<h2>Contenido no encontrado</h2>
	
			<div class="post-body caja-content">
				
				<p>Por favor vuelva a intentar utilizando nuestro buscador:</p>
							
				<p>
				<div id="searchfield">
					<?php $search_text = "Buscar"; ?>
					<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
					<input type="text" class="campo" value="Buscar" name="s" id="s" class="searchbox" onblur="if (this.value == '') {this.value = 'Buscar';}" onfocus="if (this.value == '<?php echo $search_text; ?>') {this.value = '';}" /> 
					<input type="button" id="searchsubmit" class="boton" value="Buscar" />
					</form>
				</div>
				 </p>
			</div>

	<?php endif; ?>
	
	</main><!-- content -->

<?php include(TEMPLATEPATH."/sidebar.php");?>

<?php get_footer(); ?>