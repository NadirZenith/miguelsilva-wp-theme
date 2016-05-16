<div data-ride="carousel" class="carousel slide" id="nz-bs-carousel-1">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li class="active" data-slide-to="0" data-target="#nz-bs-carousel-1"></li>
        <li data-slide-to="1" data-target="#nz-bs-carousel-1" class=""></li>
    </ol>
    <!-- Wrapper for slides -->
    <div role="listbox" class="carousel-inner">
        <?php
        $divisible = 3;
        $count = 0;
        ?>
        <?php
        if ($query->have_posts()) {
            ?>
            <div class="item active">
                <div class="row">
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();

                        if ($count != 0 && $count % $divisible == 0) {
                            ?> </div> </div> <div class="item"> <div class="row">
                        <?php } ?>

                        <div class="<?php echo ($count != 0 && $count % $divisible == 0) ? 'hidden-xs' : 'col-xs-6'; ?> col-sm-4">
                            <a data-toggle="popover" href="#" class="single-event">
                                <img src="<?php the_post_thumbnail_url('full'); ?>">
                            </a>
                        </div>
                        <?php
                        $count ++;
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="img-responsive" id="modalimagepreview" alt="modal-img" >
            </div>
        </div>
    </div>
</div>


