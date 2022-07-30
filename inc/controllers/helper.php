<?php


namespace SWPS\Inc;

class helper
{

    /**
     * auto login by user id
     */
    public static function auto_login($user_id)
    {
        if (!is_user_logged_in()) {
            $user      = get_user_by('id', $user_id);
            $user_name = $user->user_login;
            //login
            wp_set_current_user($user_id, $user_name);
            wp_set_auth_cookie($user_id);
            do_action('wp_login', $user_name, $user);
        }
    }

    /**
     * Checks if a user has a role.
     * @param $user
     * @param mixed ...$roles
     * @return bool
     */
    public static function has_role($user, ...$roles): bool
    {

        if ($user instanceof \WP_Comment) {
            $user = get_userdata($user->user_id);
        } elseif ($user === 0) {
            $user = wp_get_current_user();
        } elseif (!is_object($user)) {
            $user = get_userdata($user);
        }


        if (empty($user)) {
            return false;
        }

        $can = false;
        if (is_array($roles)) {
            foreach ($roles as $role) {
                $can = in_array($role, $user->roles, true);
                if ($can) {
                    break;
                }
            }
        } else {
            $can = in_array($roles, $user->roles, true);
        }
        return $can;
    }

    /**
     * Returns the list of parent categories
     * @param $taxonomy
     * @return int[]|string|string[]|\WP_Error|\WP_Term[]
     */
    public static function getParentTaxList($taxonomy)
    {
        return get_terms([
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
            'parent'     => 0
        ]);
    }

    /**
     * upload file with ajax
     * @param $files //$_FILES
     * @return array|string[]
     */
    public static function handleUpload($files)
    {
        // These files need to be included as dependencies when on the front end.
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        //    return $files;
        foreach ($files as $file => $array) {

            if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) { // If there is some errors, during file upload
                return array('status' => 'error', 'message' => __('Error: ', 'dokan-dashboard') . $_FILES[$file]['error']);
            }

            // HANDLE RECEIVED FILE

            $post_id = 0; // Set post ID to attach uploaded image to specific post

            $attachment_id = media_handle_upload($file, $post_id);

            if (is_wp_error($attachment_id)) { // Check for errors during attachment creation
                return array(
                    'status'  => 'error',
                    'message' => __('Error while processing file', 'dokan-dashboard'),
                );
            } else {
                return array(
                    'status'        => 'ok',
                    'attachment_id' => $attachment_id,
                    'message'       => __('File uploaded', 'dokan-dashboard'),
                );
            }
        }
    }

}