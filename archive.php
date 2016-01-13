<?php get_header(); ?>

<div id="blog" class="col-xs-12 col-md-9 clearfix">

<div class="row">

	<?php if (have_posts()) : ?>

	<h2><?php single_cat_title(); ?></h2>

	<?php include(TEMPLATEPATH."/pagination.php");?>

	<div class="caja">

	<?php while (have_posts()) : the_post(); ?>

			<div class="box">
				<a href="<?php the_permalink() ?>"><img src="<?php $values = get_post_custom_values("imagen-chica"); echo $values[0]; ?>" /></a>
				<div class="excerpt">
					<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
					<p><?php echo the_excerpt(); ?></p>
				</div>
			</div>
			<?php endwhile; ?>

	</div><!-- caja-archive -->

	<?php include(TEMPLATEPATH."/pagination.php");?>

	<?php else : ?>
		<?php include(TEMPLATEPATH."/error-content.php");?>
	<?php endif; ?>

	</div><!-- blog -->
</div><!-- content -->

<div class="col-xs-12 col-md-3">
	<?php include(TEMPLATEPATH."/sidebar.php");?>
</div>

<?php get_footer(); ?>
