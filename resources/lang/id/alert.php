<?php

return [
    //general
    'success_title' => 'Success',
    'error_title' => 'Failed',
    'info_title' => 'Info',
    'warning_title' => 'Warning',
    'wrong_text' => 'Someting went wrong!',
    'read_failed' => 'Get :attribute failed',
    'create_success' => ':attribute created successfully',
    'create_failed' => 'Create :attribute failed',
    'update_success' => ':attribute updated successfully',
    'update_failed' => 'Update :attribute Failed',
    'delete_success' => ':attribute deleted successfully',
    'delete_failed' => 'Delete :attribute failed',
    'delete_failed_used' => 'Delete :attribute failed, because it is still in use',
    'restore_success' => ':attribute restored successfully',
    //alert
    'modal_ok_caption' => 'Ok',
    'modal_cancel_caption' => 'Close',
    //delete alert
    'delete_confirm_title' => "You won't be able to revert this!",
    'delete_confirm_trash_title' => "Data will be moved to the trash!",
    'delete_confirm_restore_title' => "Data will be restored!",
    'delete_confirm_text' => 'Are you sure ?',
    'delete_attr_confirm_text' => 'Are you sure delete this :attribute ?',
    'delete_btn_yes' => 'Yes, Delete',
    'delete_btn_cancel' => 'No, Thanks',
    //auth
    'access_denied' => 'Access Denied !',
    'auth_required' => 'Auth Required',
    'auth_failed' => 'Authentification Failed',
    'auth_success' => 'Authentification Success',
    'invalid_token' => 'Invalid Token',
    'session_expired' => 'Session Expired',
    //error code
    'errors' => [
        401 => [
            'title' => 'Unauthorize',
            'text' => '',
        ],
        403 => [
            'title' => 'Forbidden',
            'text' => 'You dont have permission to access / on this server.',
        ],
        404 => [
            'title' => 'Not Found',
            'text' => 'Sorry, the page you are looking for is not found',
        ],
        419 => [
            'title' => 'Page Expired',
            'text' => 'Refresh your browser after click button back',
        ],
        429 => [
            'title' => 'Too Many Requests',
            'text' => '',
        ],
        500 => [
            'title' => 'Server Error',
            'text' => 'Something went wrong on our servers',
        ],
        503 => [
            'title' => 'Service Unavailable',
            'text' => '',
        ],
        'maintenance' => [
            'title' => 'Website Under Maintenance',
            'text' => 'Please Come Back Later',
        ],
    ],
];