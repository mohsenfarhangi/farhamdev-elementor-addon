<?php
if (!defined('ABSPATH')) {
    exit(404);
}

new \SWPS\Inc\RewriteRulesController();

add_action('rest_api_init', function () {
    $controller = new \SWPS\Inc\Rest\Simple_Rest_Controller();
    $controller->register_routes();
});