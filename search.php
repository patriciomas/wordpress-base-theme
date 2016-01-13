<?php get_header(); ?>

	<main id="content" class="search">

	<?php include(TEMPLATEPATH."/breadcrumb.php");?>

	<?php if (have_posts()) : ?>

	<h2><?php echo('Resultados de "' . get_search_query() . '"'  ); ?></h2>

	<?php include(TEMPLATEPATH."/pagination.php");?>

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

	<?php include(TEMPLATEPATH."/pagination.php");?>

	<?php else : ?>
		<?php include(TEMPLATEPATH."/error-content.php");?>
	<?php endif; ?>

	<?php endif; ?>

	</main><!-- content -->

<?php include(TEMPLATEPATH."/sidebar.php");?>

<?php get_footer(); ?>
