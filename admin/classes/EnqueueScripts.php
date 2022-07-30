<?php


namespace SWPS\Admin;


class EnqueueScripts
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'adminScripts']);
    }

    public function adminScripts()
    {
        wp_enqueue_style('main-admin', SWPS_URL . '/assets/css/admin-style.css');

        wp_enqueue_script('main-admin', SWPS_URL . '/assets/js/admin-main.js', ['jquery', 'fdup-datatable'], false, true);
        wp_localize_script('main-admin', 'object_name', [
            'loader_gif' => SWPS_URL . '/assets/media/loader-200px.gif',
            'assets_url' => SWPS_URL . './assets/'
        ]);
    }
}
