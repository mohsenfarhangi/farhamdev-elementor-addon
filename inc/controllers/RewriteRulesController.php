<?php


namespace SWPS\Inc;


class RewriteRulesController
{

    public function __construct()
    {
        /**
         * Create a new URL for the profile
         */
        add_action('init', [$this, 'add_profile_rewrite_rule']);
        /**
         * Add new query vars
         */
        add_filter('query_vars', [$this, 'profile_query_vars']);
        /**
         *
         */
        add_filter('template_include', [$this, 'doctorConsultation']);
    }

    public function add_profile_rewrite_rule()
    {
        //chat consultation
        add_rewrite_rule('variable-name/([a-z0-9-]+)[/]?$', 'index.php?variable-name=$matches[1]', 'top');
    }

    /**
     * @return array
     */
    public function profile_query_vars($query_vars)
    {
        $query_vars[] = 'variable-name';
        return $query_vars;
    }

    /**
     * @param $template
     * @return string
     */
    public function doctorConsultation($template)
    {
        global $wp;
        if (isset($wp->query_vars['variable-name']) && !empty($wp->query_vars['variable-name'])) {
            //do some thing...
        }
        return $template;
    }


}