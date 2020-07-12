<?php
namespace Tasyakur\Controllers\Traits;

trait WpNonce
{
    /**
     * Determines if the nonce variable associated with the options page is set
     * and is valid.
     *
     * @access private
     *
     * @param string $fieldKey
     * @param string $action
     * @return boolean False if the field isn't set or the nonce value is invalid;
     *                 otherwise, true.
     */
    protected function hasValidNonce(string $fieldKey, string $action): bool
    {
        // If the field isn't even in the $_POST, then it's invalid.
        if (!isset($_POST[$fieldKey]))
            return false;

        $field = wp_unslash($_POST[$fieldKey]);

        return (bool)wp_verify_nonce($field, $action);
    }
}