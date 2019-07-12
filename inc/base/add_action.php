<?php
/**
 * _ferret's action
 * @package _ferret
 */
/**
 * main page col
 */
add_action('_ferret_get_main_col', '_ferret_get_main_col');
add_action('_ferret_get_main_col_end', '_ferret_get_main_col_end');
add_action('_ferret_get_sidebar_col', '_ferret_get_sidebar_col');


/**
 * action's function
 */

if ( !function_exists('_ferret_get_main_col') ):

    function _ferret_get_main_col()
    {
        if ( _ferret_check_widget() ):
            $col = 'main-has-sidebar col-md-8 order-1' . ' ' . _ferret_get_widget_col();
        else:
            $col = 'col-md-12';
        endif;
        echo '<main id="main" class="site-main ' . $col . '">';
        echo '<section class="site-main-wrap">';
    }

endif;

if ( !function_exists('_ferret_get_main_col_end') ):
    function _ferret_get_main_col_end()
    {
        echo '</section>';
        echo '</main>';
    }
endif;


if ( !function_exists('_ferret_get_sidebar_col') ):
    function _ferret_get_sidebar_col()
    {
        if ( _ferret_check_widget() ):
            echo '<section class="sidebar col-md-4 order-2">';
            print_r('<div class="sidebar-wrap">');
            _ferret_display_widget();
            print_r('</div>');
            echo '</section>';
        endif;
    }
endif;