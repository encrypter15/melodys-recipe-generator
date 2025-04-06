/*
 * File: script.js
 * Description: Handles frontend interaction for Melody's Recipe Generator
 * Version: 0.01
 * Author: Rick Hayes
 * License: MIT
 */

jQuery(document).ready(function($) {
    // Trigger recipe search on button click
    $('#generate-recipes').click(function() {
        var ingredients = $('#ingredients').val();
        if (ingredients) {
            $.ajax({
                url: '/wp-admin/admin-ajax.php', // WordPress AJAX endpoint
                method: 'POST',
                data: {
                    action: 'get_recipe_suggestions',
                    ingredients: ingredients
                },
                success: function(response) {
                    $('#recipe-results').html(response);
                },
                error: function() {
                    $('#recipe-results').html('<p>Error fetching recipes. Please try again.</p>');
                }
            });
        }
    });
});