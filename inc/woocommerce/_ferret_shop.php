<?php
// Register Custom Post Type
flush_rewrite_rules();

function _ferret_shop()
{

    $labels = array(
        'name'                  => _x('SHOP', 'Post Type General Name', '_ferret'),
        'singular_name'         => _x('_ferret_shop', 'Post Type Singular Name', '_ferret'),
        'menu_name'             => __('SHOP', '_ferret'),
        'name_admin_bar'        => __('SHOP', '_ferret'),
        'archives'              => __('Item Archives', '_ferret'),
        'attributes'            => __('Item Attributes', '_ferret'),
        'parent_item_colon'     => __('Parent Item:', '_ferret'),
        'all_items'             => __('All Items', '_ferret'),
        'add_new_item'          => __('Add New Product', '_ferret'),
        'add_new'               => __('Add New Product', '_ferret'),
        'new_item'              => __('New Item', '_ferret'),
        'edit_item'             => __('Edit Item', '_ferret'),
        'update_item'           => __('Update Item', '_ferret'),
        'view_item'             => __('View Item', '_ferret'),
        'view_items'            => __('View Items', '_ferret'),
        'search_items'          => __('Search Item', '_ferret'),
        'not_found'             => __('Not found', '_ferret'),
        'not_found_in_trash'    => __('Not found in Trash', '_ferret'),
        'featured_image'        => __('Featured Image', '_ferret'),
        'set_featured_image'    => __('Set featured image', '_ferret'),
        'remove_featured_image' => __('Remove featured image', '_ferret'),
        'use_featured_image'    => __('Use as featured image', '_ferret'),
        'insert_into_item'      => __('Insert into item', '_ferret'),
        'uploaded_to_this_item' => __('Uploaded to this item', '_ferret'),
        'items_list'            => __('Items list', '_ferret'),
        'items_list_navigation' => __('Items list navigation', '_ferret'),
        'filter_items_list'     => __('Filter items list', '_ferret'),
    );
    $args   = array(
        'label'               => __('_ferret_shop', '_ferret'),
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'post-formats', 'thumbnail'),
        'taxonomies'          => array('_ferret_shop_categories', 'post_tag'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'menu_position'       => 1,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'rewrite'             => true
    );
    register_post_type('_ferret_shop', $args);

}

add_action('init', '_ferret_shop', 0);


function _ferret_shop_info_get_meta($value)
{
    global $post;

    $field = get_post_meta($post->ID, $value, true);
    if (!empty($field)) {
        return is_array($field) ? stripslashes_deep($field) : stripslashes(wp_kses_decode_entities($field));
    } else {
        return false;
    }
}

add_action('add_meta_boxes', '_ferret_shop_info_add_meta_box');

function _ferret_shop_info_add_meta_box()
{
    add_meta_box(
        '_ferret_shop_info-_ferret_shop-info',
        __('商品基本情報', '_ferret'),
        '_ferret_shop_info_html',
        '_ferret_shop',
        'advanced',
        'high'
    );
}

add_action('edit_form_after_title', '_ferret_shop_move_metabox_after_title');

function _ferret_shop_move_metabox_after_title()
{
    global $post, $wp_meta_boxes;
    do_meta_boxes(get_current_screen(), 'advanced', $post);
    unset($wp_meta_boxes[get_post_type($post)]['advanced']);
}




function _ferret_shop_info_html($post)
{
    wp_nonce_field('__ferret_shop_info_nonce', '_ferret_shop_info_nonce'); ?>
    <div style="display:flex;align-items: center;justify-content: flex-start;">
    <p style="margin-right:20px;">
        <label for="_ferret_shop_info__ferret_shop_price"><?php _e('販売価格', '_ferret'); ?></label><br>
        <input type="text" name="_ferret_shop_info__ferret_shop_price" id="_ferret_shop_info__ferret_shop_price"
               value="<?php echo _ferret_shop_info_get_meta('_ferret_shop_info__ferret_shop_price'); ?>">
    </p>
    <p style="margin-right:20px;">
        <label for="_ferret_shop_info__ferret_shop_stock"><?php _e('数量', '_ferret'); ?></label><br>
        <input type="text" name="_ferret_shop_info__ferret_shop_stock" id="_ferret_shop_info__ferret_shop_stock"
               value="<?php echo _ferret_shop_info_get_meta('_ferret_shop_info__ferret_shop_stock'); ?>">
    </p>
        <p style="margin-right:20px;">
            <label for="_ferret_shop_info__ferret_shop_number"><?php _e('商品番号', '_ferret'); ?></label><br>
            <input type="text" name="_ferret_shop_info__ferret_shop_number" id="_ferret_shop_info__ferret_shop_number"
                   value="<?php echo _ferret_shop_info_get_meta('_ferret_shop_info__ferret_shop_number'); ?>">
        </p>
        <p style="margin-right:20px;">
            <label for="_ferret_shop_info__ferret_shop_jancode"><?php _e('ＪＡＮコード', '_ferret'); ?></label><br>
            <input type="text" name="_ferret_shop_info__ferret_shop_jancode" id="_ferret_shop_info__ferret_shop_jancode"
                   value="<?php echo _ferret_shop_info_get_meta('_ferret_shop_info__ferret_shop_jancode'); ?>">
        </p>
    </div>
    <?php
}

function _ferret_shop_info_save($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['_ferret_shop_info_nonce']) || !wp_verify_nonce($_POST['_ferret_shop_info_nonce'], '__ferret_shop_info_nonce')) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['_ferret_shop_info__ferret_shop_price']))
        update_post_meta($post_id, '_ferret_shop_info__ferret_shop_price', esc_attr($_POST['_ferret_shop_info__ferret_shop_price']));
    if (isset($_POST['_ferret_shop_info__ferret_shop_stock']))
        update_post_meta($post_id, '_ferret_shop_info__ferret_shop_stock', esc_attr($_POST['_ferret_shop_info__ferret_shop_stock']));

    if (isset($_POST['_ferret_shop_info__ferret_shop_number']))
        update_post_meta($post_id, '_ferret_shop_info__ferret_shop_number', esc_attr($_POST['_ferret_shop_info__ferret_shop_number']));
    if (isset($_POST['_ferret_shop_info__ferret_shop_jancode']))
        update_post_meta($post_id, '_ferret_shop_info__ferret_shop_jancode', esc_attr($_POST['_ferret_shop_info__ferret_shop_jancode']));

}

add_action('save_post', '_ferret_shop_info_save');

/*
	Usage: _ferret_shop_info_get_meta( '_ferret_shop_info__ferret_shop_price' )
	Usage: _ferret_shop_info_get_meta( '_ferret_shop_info__ferret_shop_stock' )
*/
function _ferret_shop_create_portfolio_taxonomies()
{
    $labels = array(
        'name'              => _x('Categorys', '_ferret'),
        'singular_name'     => _x('Category', '_ferret'),
        'search_items'      => __('Search Categories'),
        'all_items'         => __('All Categories'),
        'parent_item'       => __('Parent Category'),
        'parent_item_colon' => __('Parent Category:'),
        'edit_item'         => __('Edit Category'),
        'update_item'       => __('Update Category'),
        'add_new_item'      => __('Add New Category'),
        'new_item_name'     => __('New Category Name'),
        'menu_name'         => __('Category'),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'ShopCategory'),
    );

    register_taxonomy('_ferret_shop_categories', array('_ferret_shop'), $args);
}

add_action('init', '_ferret_shop_create_portfolio_taxonomies', 0);


function _ferret_shop_cpt_generating_rule($wp_rewrite) {
    $rules = array();
    $terms = get_terms( array(
        'taxonomy' => '_ferret_shop_categories',
        'hide_empty' => false,
    ) );

    $post_type = '_ferret_shop';
    foreach ($terms as $term) {

        $rules['ShopCategory/' . $term->slug . '/([^/]*)$'] = 'index.php?post_type=' . $post_type. '&'.$post_type.'=$matches[1]&name=$matches[1]';

    }
    // merge with global rules
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
}
add_filter('generate_rewrite_rules', '_ferret_shop_cpt_generating_rule');


function _ferret_shop_change_link( $permalink, $post ) {

    if( $post->post_type == '_ferret_shop' ) {
        $resource_terms = get_the_terms( $post, '_ferret_shop_categories' );
        $term_slug = '';
        if( ! empty( $resource_terms ) ) {
            foreach ( $resource_terms as $term ) {
                // The featured resource will have another category which is the main one
                if( $term->slug == 'featured' ) {
                    continue;
                }
                $term_slug = $term->slug;
                break;
            }
        }
        $permalink = get_home_url() ."/ShopCategory/" . $term_slug . '/' . $post->post_name;
    }
    return $permalink;
}
add_filter('post_type_link',"_ferret_shop_change_link",10,2);

