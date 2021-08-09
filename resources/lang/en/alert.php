<?php

return [
    'system_app_load_fail_title' => 'Application failed.',
    'system_app_load_fail_text' => 'Application not loded properly, please try to reload the page.',
    // GENERAL
    'form_must_complete_title' => 'Input form error',
    'form_must_complete_text' => 'Please fix the error',
    'success_title' => 'Success',
    'error_title' => 'Failed',
    'info_title' => 'Info',
    'warning_title' => 'Warning',
    'default_text' => 'Someting went wrong!',
    'read_failed' => 'Get :attribute failed',
    'create_failed' => 'Create :attribute failed',
    'create_success' => ':attribute created successfully',
    'update_failed' => 'Update :attribute Failed',
    'update_success' => ':attribute updated successfully',
    'delete_failed' => 'Delete :attribute failed',
    'delete_success' => ':attribute deleted successfully',
    'delete_failed_used' => 'Delete :attribute failed, because it is still in use',
    'restore_success' => ':attribute restored successfully',
    'incorect_parameter' => 'Incorect Parameter',
    'resource_not_found' => 'Resource not found',
    'position_change' => 'Position :attribute changed',
    //default alert modal
    'modal_ok_caption' => 'Ok',
    'modal_cancel_caption' => 'Close',
    //delete confirmation alert
    'delete_confirm_title' => "You won't be able to revert this!",
    'delete_confirm_trash_title' => "Data will be moved to the trash!",
    'delete_confirm_restore_title' => "Data will be restored!",
    'delete_confirm_text' => 'Are you sure ?',
    'delete_attr_confirm_text' => 'Are you sure delete this :attribute ?',
    'delete_btn_yes' => 'Yes, Delete',
    'delete_btn_cancel' => 'No, Thanks',
    // AUTH
    'access_denied' => 'Access Denied !',
    'auth_required' => 'Auth Required',
    'auth_failed' => 'Authentification Failed',//error saat login gagal
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