<?php
/*
 * Class: MRG_Shortcode
 * Description: Registers and renders the recipe generator shortcode
 * Version: 0.01
 * Author: Rick Hayes
 * License: MIT
 */

class MRG_Shortcode {
    public function __construct() {
        add_shortcode('recipe_generator', array($this, 'render_generator'));
    }

    /**
     * Render the recipe generator form
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render_generator($atts) {
        ob_start();
        ?>
        <div id="recipe-generator">
            <h3>Enter Your Ingredients</h3>
            <input type="text" id="ingredients" placeholder="e.g., chicken, rice, soy sauce" />
            <button id="generate-recipes">Find Recipes</button>
            <div id="recipe-results"></div>
        </div>
        <?php
        return ob_get_clean();
    }
}
new MRG_Shortcode();