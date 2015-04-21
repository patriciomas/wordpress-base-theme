<?php get_header(); ?>

	<main id="content">
	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<article class="post-body">
			<h2><?php the_title(); ?></h2>
			<div>
				<?php the_content(); ?>
			</div>
		</article>

		<?php endwhile; endif; ?>
	
	</main><!-- content -->

<?php include(TEMPLATEPATH."/sidebar.php");?>

<?php get_footer(); ?>