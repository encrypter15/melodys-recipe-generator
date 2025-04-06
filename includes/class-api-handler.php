<?php
/*
 * Class: MRG_API_Handler
 * Description: Fetches recipes from an external API (e.g., Spoonacular)
 * Version: 0.01
 * Author: Rick Hayes
 * License: MIT
 */

class MRG_API_Handler {
    // Replace with your Spoonacular API key
    private $api_key = '';

    /**
     * Fetch recipes from Spoonacular API based on ingredients
     * @param string $ingredients Comma-separated list of ingredients
     * @return array|bool Array of recipes or false on failure
     */
    public function fetch_recipes($ingredients) {
        $url = "https://api.spoonacular.com/recipes/findByIngredients?ingredients=" . urlencode($ingredients) . "&apiKey=" . $this->api_key;
        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            return false;
        }

        return json_decode(wp_remote_retrieve_body($response));
    }
}
