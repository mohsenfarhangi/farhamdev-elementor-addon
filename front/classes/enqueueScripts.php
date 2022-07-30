<?php


namespace SWPS\Front;


class enqueueScripts
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_front_scripts']);
    }

    function enqueue_front_scripts()
    {

        wp_enqueue_style('main-style', SWPS_URL . 'assets/front/css/style.css');

        wp_enqueue_script('main-script', SWPS_URL . 'assets/front/js/frontjs.js', ['jquery'], false, true);
        wp_localize_script('main-script', 'object_name', [
            'ajaxurl' => admin_url('admin-ajax.php?_nonce=' . wp_create_nonce('_nonce_field_protection')),
        ]);

    }
}