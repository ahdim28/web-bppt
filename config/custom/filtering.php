<?php

return [
    'limit' => [
        10 => '10',
        25 => '25',
        50 => '50',
        100 => '100',
    ],
    'visitor' => [
        'today' => 'mod/setting.visitor.filter.today',
        'current-week' => 'mod/setting.visitor.filter.current-week',
        'latest-week' => 'mod/setting.visitor.filter.latest-week',
        'current-month' => 'mod/setting.visitor.filter.current-month',
        'latest-month' => 'mod/setting.visitor.filter.latest-month',
        'current-year' => 'mod/setting.visitor.filter.current-year',
        'latest-year' => 'mod/setting.visitor.filter.latest-year',
    ],
    'ordering' => [
        0 => [
            'title' => 'ASC',
            'description' => 'ASCENDING',
        ],
        1 => [
            'title' => 'DESC',
            'description' => 'DESCENDING',
        ]
    ],
    'ordering_field_posts' => [
        0 => 'id',
        2 => 'position',
        3 => 'viewer',
        4 => 'created_at',
        5 => 'updated_at',
    ],
];