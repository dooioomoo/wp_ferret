<?php
/**
 * _ferret's index page
 * @package _ferret
 */

get_header();
?>
<div class="container">
    <?php if ( _ferret_check_widget() )echo 'yes';?>
</div>

<?php
    _ferret_display_widget();

get_footer();

