<?php


namespace SWPS\Inc\Rest;


use WP_REST_Server;

class Simple_Rest_Controller extends \WP_REST_Controller
{
    /**
     * Endpoint namespace
     *
     * @var string
     */
    protected $namespace = 'v1/swps';

    /**
     * Route name
     *
     * @var string
     */
    protected $base = 'simple';

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes()
    {

        register_rest_route($this->namespace, '/' . $this->base, [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'get_items'],
                'permission_callback' => [$this, 'get_items_permissions_check'],
                'args'                => $this->get_endpoint_args_for_item_schema(false),
            ]
        ]);

    }

    public function auth($request){
        $data = $request['username'];
        return new \WP_REST_Response($data, 200);
    }

    public function get_items($request)
    {
        return parent::get_item($request); // TODO: Change the autogenerated stub
    }

    public function get_items_permissions_check($request)
    {
        return parent::get_items_permissions_check($request); // TODO: Change the autogenerated stub
    }
}