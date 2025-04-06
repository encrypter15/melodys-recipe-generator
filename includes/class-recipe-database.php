<?php
/*
 * Class: MRG_Recipe_Database
 * Description: Handles recipe storage and retrieval from WordPress database (optional)
 * Version: 0.01
 * Author: Rick Hayes
 * License: MIT
 */

class MRG_Recipe_Database {
    /**
     * Fetch recipes based on ingredients from custom post type 'recipe'
     * @param string $ingredients Comma-separated list of ingredients
     * @return array List of matching recipe posts
     */
    public static function get_recipes($ingredients) {
        $args = array(
            'post_type' => 'recipe',
            'meta_query' => array(
                array(
                    'key' => 'ingredients',
                    'value' => $ingredients,
                    'compare' => 'LIKE'
                )
            )
        );
        $query = new WP_Query($args);
        return $query->posts;
    }
}