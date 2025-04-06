<?php
/*
Plugin Name: Melody's Recipe Generator
Description: Generate recipes based on ingredients for melodyskitchen.com
Version: 0.01
Author: Rick Hayes
License: MIT
License URI: https://opensource.org/licenses/MIT
*/

// MIT License
/*
Copyright (c) 2025 Rick Hayes

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Load required classes
require_once plugin_dir_path(__FILE__) . 'includes/class-recipe-database.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-api-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-shortcode.php';

// Enqueue frontend scripts and styles
function mrg_enqueue_assets() {
    wp_enqueue_style('mrg-style', plugins_url('/assets/css/style.css', __FILE__), array(), '0.01');
    wp_enqueue_script('mrg-script', plugins_url('/assets/js/script.js', __FILE__), array('jquery'), '0.01', true);
}
add_action('wp_enqueue_scripts', 'mrg_enqueue_assets');

// AJAX handler for recipe suggestions
add_action('wp_ajax_get_recipe_suggestions', 'mrg_get_recipe_suggestions');
add_action('wp_ajax_nopriv_get_recipe_suggestions', 'mrg_get_recipe_suggestions'); // Allow non-logged-in users
function mrg_get_recipe_suggestions() {
    // Sanitize input
    $ingredients = sanitize_text_field($_POST['ingredients']);
    
    // Use API handler to fetch recipes
    $api_handler = new MRG_API_Handler();
    $recipes = $api_handler->fetch_recipes($ingredients);

    // Output results
    if ($recipes) {
        foreach ($recipes as $recipe) {
            echo '<h4>' . esc_html($recipe->title) . '</h4>';
            echo '<p>Ingredients: ' . esc_html(implode(', ', array_column($recipe->usedIngredients, 'name'))) . '</p>';
        }
    } else {
        echo '<p>No recipes found. Try different ingredients!</p>';
    }
    wp_die(); // Required to end AJAX request
}