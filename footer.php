    
    <footer id="footer">

        <?php wp_nav_menu(array('menu' => 'Footer Menu', 'container' => 'nav', 'container_class' => 'menu-footer')); ?>

        <div id="info">
        	<p class="copyright">Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?></p>
			<p class="credits">Dise&ntilde;o e implementaci&oacute;n <a href="http://pixelkit.cl" target="_blank">Pixelkit</a></p>
        </div>		
    </footer><!-- footer -->

</div><!-- container -->

<?php wp_footer(); ?>

</body>
</html>
