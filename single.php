<?php get_header(); ?>

	<main id="content">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<article class="post-body">
			<h2><?php the_title(); ?></h2>
			<div>
				<?php the_content(); ?>
			</div>
		</article>
	
		<div class="post-navigation">
			<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&larr; Previa</span>' ); ?></div>
			<div class="nav-next"><?php next_post_link( '%link', '<span class="meta-nav">Siguiente &rarr;</span>' ); ?></div>
		</div><!-- #nav-above -->

	<?php endwhile; endif; ?>
	
    </main><!-- content -->

<?php include(TEMPLATEPATH."/sidebar.php");?>

<?php get_footer(); ?>