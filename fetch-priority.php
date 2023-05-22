<?php
/*
Plugin Name: Fetch Priority
Description: Adds the fetchpriority attribute to the first three images or videos above the fold to improve page load times.
Version: 1.0
Author: Carmelyne
*/

function add_fetch_priority() {
    echo "
    <script>
    // Attaches an event listener to the 'DOMContentLoaded' event
    document.addEventListener('DOMContentLoaded', (event) => {
        // Selects all 'img' elements on the page
        let images = document.querySelectorAll('img');
        // Selects all 'video' elements on the page
        let videos = document.querySelectorAll('video');

        // Loops through the first three 'img' elements
        for (let i = 0; i < images.length && i < 3; i++) {
            // Sets the 'fetchpriority' attribute of the current 'img' element to 'high'
            images[i].setAttribute('fetchpriority', 'high');
        }

        // Checks if there is at least one 'video' element on the page
        if (videos.length > 0) {
            // Sets the 'fetchpriority' attribute of the first 'video' element to 'high'
            videos[0].setAttribute('fetchpriority', 'high');
        }
    });
    </script>
    ";
}

// Adds the 'add_fetch_priority' function to the 'wp_footer' action
add_action('wp_footer', 'add_fetch_priority');



?>
