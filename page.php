<?php get_header(); ?>

<div class="row">

	<main id="content" class="col-sm-12 col-md-8">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article class="post-body">
			<h2><?php the_title(); ?></h2>
			<div>
				<?php the_content(); ?>
			</div>
		</article>

		<?php endwhile; endif; ?>

	</main><!-- content -->

	<div class="col-sm-12 col-md-4">
		<?php include(TEMPLATEPATH."/sidebar.php");?>
	</div>

</div>

<?php get_footer(); ?>
