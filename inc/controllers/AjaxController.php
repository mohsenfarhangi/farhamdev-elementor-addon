<?php

namespace SWPS\Inc;

use WP_Error;

if (!defined('ABSPATH')) {
    exit(404);
}

abstract class AjaxController
{
    private array $list_no_private = [];
    private array $list_priv       = [];
    private array $list_admin      = [];
    private       $errors;
    private       $error_message;

    public function __construct()
    {
        $this->ajax_action_list();
    }

    /**
     * ['action' => 'callBack']
     */
    public function setListNoPrivate(): void
    {
        $this->list_no_private = [];
    }

    /**
     * @return array
     */
    public function getListNoPrivate(): array
    {
        return $this->list_no_private;
    }

    /**
     * ['action' => 'callBack']
     */
    public function setListPriv(): void
    {
        $this->list_priv = [];
    }

    /**
     * @return array
     */
    public function getListPriv(): array
    {
        return $this->list_priv;
    }

    /**
     * ['action' => 'callBack']
     */
    public function setListAdmin(): void
    {
        $this->list_admin = [];
    }

    /**
     * @return array
     */
    public function getListAdmin(): array
    {
        return $this->list_admin;
    }

    /**
     * @param $error_key
     * @param $error_message
     */
    public function setErrors($error_key, $error_message): void
    {
        $this->errors->add($error_key, $error_message);
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function ajax_action_list()
    {
        $this->error_message = [
            'nonce_not_verified' => __('Your time to complete this operation has expired. Try again.', 'telaram-profile'),
            'unknown_error'      => __('An error occurred during operation. Try again.', 'telaram-profile')
        ];

        $this->setListAdmin();
        $this->setListPriv();
        $this->setListNoPrivate();

        foreach ($this->getListNoPrivate() as $action => $call_back) {
            add_action('wp_ajax_nopriv_' . $action, [$this, $call_back]);
            add_action('wp_ajax_' . $action, [$this, $call_back]);
        }

        foreach ($this->getListPriv() as $action => $call_back) {
            add_action('wp_ajax_' . $action, [$this, $call_back]);
        }

        if (is_admin()) {
            foreach ($this->getListAdmin() as $action => $call_back) {
                add_action('wp_ajax_nopriv_' . $action, [$this, $call_back]);
            }
        }

        $this->errors = new WP_Error();
    }

    public function check_nonce_field($action, $name)
    {
        if (!wp_verify_nonce($name, $action)) {
            $this->errors->add('nonce_not_verified', $this->error_message['nonce_not_verified']);
            $this->check_error();
        }
    }

    public function check_error($error_object = null)
    {
        if (empty($error_object)) {
            if ($this->errors->has_errors()) {
                echo wp_json_encode(
                    [
                        'error'  => $this->errors,
                        'result' => 0
                    ]
                );
                exit();
            }
        } elseif (is_wp_error($error_object)) {
            if ($error_object->has_errors()) {
                echo wp_json_encode([
                    'error'  => $error_object,
                    'result' => 0
                ]);
                exit();
            }
        }
    }

}