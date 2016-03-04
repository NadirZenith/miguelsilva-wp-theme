<footer id="page-footer" role="contentinfo" class="full-height">

    <div id="widget-footer" class="clearfix container-fluid">

        <div class="row">
            <div class="col-sm-offset-3 col-sm-8 col-md-offset-4 col-lg-offset-3">
                <h1>Contact</h1>
                <hr class="star">

                <div class="row">

                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('smaller')) : ?>
                    <?php endif; ?>

                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('bigger')) : ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>

    <nav class="clearfix">
        <?php wp_bootstrap_footer_links(); // Adjust using Menus in Wordpress Admin ?>
    </nav>

    <p class="attribution text-center small">&copy; <?php bloginfo('name'); ?></p>


</footer> <!-- end footer -->


<!--[if lt IE 7 ]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
        <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->

<?php wp_footer(); // js scripts are inserted using this function ?>

<!-- remove this for production -->

<script src="//localhost:35729/livereload.js"></script>

</body>

</html>