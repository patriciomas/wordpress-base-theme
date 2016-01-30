<?php get_header(); ?>

<div class="row">

	<main id="content" class="col-sm-12 col-md-8">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article class="post-body">
				<h1><?php the_title(); ?></h1>
				<span class="info"><?php the_date('d/m/Y'); ?> | __('Por') <?php the_author(); ?></span>
				<div>
					<?php social_sharing_buttons(); ?>
					<?php the_content(); ?>
				</div>
			</article>

		<?php include(TEMPLATEPATH."/pagination.php");?>

		<?php endwhile; endif; ?>

	</main><!-- content -->

	<div class="col-sm-12 col-md-4">
		<?php include(TEMPLATEPATH."/sidebar.php");?>
	</div>

</div>

<?php get_footer(); ?>
