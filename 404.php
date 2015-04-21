<?php get_header(); ?>

	<main id="content">
	
	<h2>P&aacute;gina no encontrada</h2>
	
		<div class="caja">
			<div class="post-body caja-content">
				<p>La p&aacute;gina a la que desea acceder, no se encuentra en este sitio.</p>
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
		</div>
	
	</main><!-- content -->
	
<?php include(TEMPLATEPATH."/sidebar.php");?>

<?php get_footer(); ?>