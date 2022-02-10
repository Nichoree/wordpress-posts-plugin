<?php
/**
 * Plugin Name:       Posts Lists Display
 * Plugin URI:        https://github.com/Nichoree/wordpress-posts-plugin
 * Description:       A wordpress plugin that allows users to display any type of post (including custom post types) in a grid using a shortcode.
 * Version:           0.1
 * Author:            Nichoree Designs
 * Author URI:        https://nichoree.com
 */



/** Adds shortcode to list posts based on different categories 
 * 
 * HOW TO USE SHORTCODE
 * [posts-list post-type="posts" category=0 number-of-posts=3]
 *      "posts" in post-type can be replaced by custom post types
 * 
*/


function posts_list_styles() {
    wp_enqueue_style( 'w3', plugin_dir_url( __FILE__ ) . '/css/w3.css', false, '' , 'all' );
    wp_enqueue_style( 'posts-list', plugin_dir_url( __FILE__ ).'/css/posts-list.css', false, '' , 'all' );
    };
add_action( 'wp_enqueue_scripts', 'posts_list_styles' );

function posts_list_shortcode($atts)
    {
        ob_start();
        $defaults = array(
            'post-type' => 'posts',
            'category' => 0,
            'number-of-posts' => -1
        );
        $post_atts = shortcode_atts($defaults, $atts, 'posts-list');
        $posts_args = array(
            'numberposts' => $post_atts['number-of-posts'],
            'post_type' => $post_atts['post-type'],
            'category_name' => $post_atts['category'],
        );

        $posts = get_posts($posts_args);

        if ($posts) { ?>
            <div class="w3-row-padding post-row">
            <?php 
            foreach($posts as $post) { ?>
            
                <div class="w3-col l4 m6 s12">
                <a href=<?php echo get_permalink($post->ID); ?>>
                <div class="posts-list-image">
                    <?php echo get_the_post_thumbnail($post->ID); ?>
            </div>
                <h4><?php echo esc_html( get_the_title($post->ID) ); ?></h4>
            </a>
            </div> 
            <?php } ?>
            </div>
            <?php
        } else { echo "<p>No posts found </p>"; }
            
        // always return
        return ob_get_clean();
    }

// Register shortcode
add_shortcode('posts-list', 'posts_list_shortcode');



