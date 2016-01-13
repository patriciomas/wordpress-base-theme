</main><!-- content -->

    <footer id="footer">

        <?php wp_nav_menu(array('menu' => 'Footer Menu', 'container' => 'nav', 'container_class' => 'menu-footer')); ?>

        <div id="info">
        	<p class="copyright">Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?></p>
    			<p class="credits">Dise&ntilde;o e implementaci&oacute;n <a href="http://sherpadigital.cl" target="_blank">Sherpa Digital</a></p>
        </div>

    </footer><!-- footer -->

</div><!-- container -->

<?php wp_footer(); ?>

<!--  Bootstrap  -->
<script src="<?php bloginfo('template_url'); ?>/css/bootstrap-3.3.6/js/bootstrap.min.js"></script>
<!-- Script calls -->
<script src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>

</body>
</html>
