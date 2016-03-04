<?php
$args = array(
    'post_type' => 'event',
    'meta_key' => 'date',
    'orderby' => 'meta_value_num',
    'order' => 'ASC'
);

/* $posts = get_posts($args); */
$loop = new WP_Query($args);
if ($loop->have_posts()):
    ?>
    <table class="table table-hover">
        <thead> 
            <tr> 
                <th class="col-lg-3 text-center">Date</th> 
                <th class="col-lg-8 text-center">Place</th> 
            </tr> 
        </thead> 
        <tbody>
            <?php
            while ($loop->have_posts()): $loop->the_post();
                $date = 'tba';
                $Date = DateTime::createFromFormat('Ymd', get_field('date'));
                if ($Date) {
                    $date = $Date->format('d-m-Y');
                }
                ?>

                <tr> 
                    <td><?php echo $date; ?></td> 
                    <td><?php the_title() ?></td> 
                </tr>
                <?php
            endwhile;
            ?>
        </tbody>
    </table>
    <?php
else :

    echo 'TBA';
endif;
wp_reset_postdata();
?>
