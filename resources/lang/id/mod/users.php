<?php

return [
    'role' => [
        'title' => 'Roles',
        'caption' => 'Role',
        'text' => 'Role List',
        'label' => [
            'field1' => 'Name',
            'field2' => 'Writing',
            'field3' => 'Guard Name',
        ],
        'placeholder' => [
            'field1' => 'Enter role name...',
        ],
        'set_permission' => 'Set Permission',
        'give_permission' => 'Give Permission For',
    ],
    'permission' => [
        'title' => 'Permissions',
        'caption' => 'Permission',
        'text' => 'Permission List',
        'label' => [
            'field1' => 'Name',
            'field2' => 'Writing',
            'field3' => 'Guard Name'
        ],
        'placeholder' => [
            'field1' => 'Enter permission name...',
        ],
    ],
    'user' => [
        'title' => 'Users',
        'caption' => 'User',
        'text' => 'User List',
        'label' => [
            'field1' => 'Name',
            'field2' => 'Email',
            'field3' => 'Username',
            'field4' => 'Email verified',
            'field5' => 'Email Verified At',
            'field6' => 'Active',
            'field7' => 'Active At',
            'field8' => 'Phone',
            'field9' => 'Password',
            'field9_1' => 'Repeat Password',
            'field9_2' => 'Old Password',
            'field10' => 'Photo',
            'field10_1' => 'Title',
            'field10_2' => 'Alt',
            'field11' => 'Role',
        ],
        'placeholder' => [
            'field1' => 'Enter name...',
            'field2' => 'Enter email...',
            'field3' => 'Enter username',
            'field4' => '',
            'field5' => '',
            'field6' => '',
            'field7' => '',
            'field8' => 'xxxxxxxxxx',
            'field9' => 'Enter password...',
            'field9_1' => 'Enter repeat password...',
            'field9_2' => 'Enter old password...',
            'field10' => '',
            'field10_1' => 'Enter title...',
            'field10_2' => 'Enter alt...',
        ],
        'last_activity' => 'Last Activity',
        'no_activity' => 'No Activity',
        'log' => [
            'title' => 'Logs',
            'caption' => 'Log',
            'label' => [
                'field1' => 'IP Address',
                'field2' => 'Event',
                'field3' => 'Description',
                'field4' => 'Date',
            ],
        ],
        'profile' => [
            'title' => 'Profile',
            'label' => [
                'field1' => 'Gender',
                'field2' => 'Place of Birth',
                'field3' => 'Date of Birth',
                'field4' => 'Address',
                'field5' => 'Postal Code',
                'field6' => 'Social Media',
                'field6_1' => ':attribute URL',
            ],
            'placeholder' => [
                'field1' => 'Gender...',
                'field2' => 'Place of Birth...',
                'field3' => 'Date of Birth...',
                'field4' => 'Address...',
                'field5' => 'Postal Code...',
                'field6' => '',
                'field6_1' => 'Enter :attribute URL...',
            ],
            'tabs' => [
                1 => 'Account',
                2 => 'Profile',
                3 => 'Change Password'
            ],
        ],
        'verification' => [
            'title' => 'Email Verification',
        ],
        'alert' => [
            'success_password' => 'Change password successfully',
            'warning_password' => 'Old Password does not match',
            'success_verification' => 'Your email is verified',
            'info_verification' => 'Check your email for verification',
            'warning_verification' => 'Send mail disabled, contact developer for activate mailing',
            'success_photo' => 'Update data photo successfully'
        ],
    ]
];