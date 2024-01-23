<?php
/*
Plugin Name: Fetch Priority Plus
Description: Enhances LCP by adding fetchpriority to images and videos and dynamically preloading key scripts and styles.
Version: 1.1
Author: Carmelyne
*/

// Fetch priority logic for images and videos
function add_fetch_priority() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        let images = document.querySelectorAll('img');
        let videos = document.querySelectorAll('video');

        // Setting fetchpriority for images
        for (let i = 0; i < Math.min(images.length, 3); i++) {
            if (images[i]) {
                images[i].setAttribute('fetchpriority', 'high');
            }
        }

        // Setting fetchpriority for the first video, if exists
        if (videos.length > 0 && videos[0]) {
            videos[0].setAttribute('fetchpriority', 'high');
        }
    });
    </script>
    <?php
}

// New dynamic preload functionality for scripts and styles
function fetch_priority_preload_resources() {
    // Only run this on the front-end
    if (!is_admin()) {
        global $wp_styles, $wp_scripts;
        $max_preloads = 2; // You can adjust this number as needed

        // Function to echo preload link
        function echo_preload_link($resource, $type) {
            if (!empty($resource->src)) {
                echo '<link rel="preload" href="' . esc_url($resource->src) . '" as="' . $type . '">' . "\n";
            }
        }

        // Preload styles - only the first few as specified by $max_preloads
        foreach (array_slice($wp_styles->queue, 0, $max_preloads) as $handle) {
            if (isset($wp_styles->registered[$handle])) {
                echo_preload_link($wp_styles->registered[$handle], 'style');
            }
        }

        // Preload scripts - only the first few as specified by $max_preloads
        foreach (array_slice($wp_scripts->queue, 0, $max_preloads) as $handle) {
            if (isset($wp_scripts->registered[$handle])) {
                echo_preload_link($wp_scripts->registered[$handle], 'script');
            }
        }
    }
}


// Adding actions
add_action('wp_footer', 'add_fetch_priority');
add_action('wp_head', 'fetch_priority_preload_resources');
?>