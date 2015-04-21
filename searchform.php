		<div id="searchfield">
			<?php $search_text = "Busca lo que m&aacute;s te interesa"; ?>
			<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
			<input type="text" class="campo" value="Busca lo que m&aacute;s te interesa" name="s" id="s" class="searchbox" onblur="if (this.value == '') {this.value = 'Busca lo que m&aacute;s te interesa';}" onfocus="if (this.value == '<?php echo $search_text; ?>') {this.value = '';}" /> 
			<input type="button" id="searchsubmit" class="boton" value="Buscar" />
			</form>
        </div>

