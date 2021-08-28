<?php

if ('x' === $_['id'] && 'get' === $_['form']['type']) {
    Hook::set('_', function($_) {
        if (isset($_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs'])) {
            $q = Get::get('find');
            $data = fetch('https://mecha-cms.com/store/extension/feed.json?chunk=' . ($q ? 9999 : ($_['chunk'] ?? 20)) . '&i=1&q=' . urlencode($q ?? ""), [
                'user-agent' => 'Mecha/' . VERSION
            ]);
            $lot = [];
            if ($data && $data = json_decode($data, true)) {
                if (isset($data[1]) && count($data[1]) > 1) {
                    foreach ($data[1] as $k => $v) {
                        $lot[] = [
                            'title' => $v['title'],
                            'description' => $v['description'],
                            'image' => $v['image'],
                            'link' => $v['url'] . '?ref=panel.store',
                            'tasks' => [
                                'pull' => [
                                    'title' => 'Install',
                                    'description' => 'Download and install',
                                    'icon' => 'M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z',
                                    'stack' => 10
                                ]
                            ]
                        ];
                    }
                }
            }
            $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['store'] = [
                'icon' => 'M19 6H17C17 3.2 14.8 1 12 1S7 3.2 7 6H5C3.9 6 3 6.9 3 8V20C3 21.1 3.9 22 5 22H19C20.1 22 21 21.1 21 20V8C21 6.9 20.1 6 19 6M12 3C13.7 3 15 4.3 15 6H9C9 4.3 10.3 3 12 3M19 20H5V8H19V20M12 12C10.3 12 9 10.7 9 9H7C7 11.8 9.2 14 12 14S17 11.8 17 9H15C15 10.7 13.7 12 12 12Z',
                'lot' => [
                    'form' => [
                        'type' => 'form/get',
                        'lot' => [
                            'fields' => [
                                'type' => 'fields',
                                'lot' => [
                                    'search' => [
                                        'name' => 'find',
                                        'type' => 'text',
                                        'hint' => 'Find extension by query...',
                                        'value' => $q,
                                        'width' => true,
                                        'stack' => 10
                                    ],
                                    'tab' => [
                                        'name' => 'tab[0]',
                                        'type' => 'hidden',
                                        'value' => 'store'
                                    ]
                                ],
                                'stack' => 10
                            ]
                        ],
                        'stack' => 10
                    ],
                    'store' => [
                        'type' => 'pages',
                        'lot' => $lot,
                        'stack' => 20
                    ]
                ],
                'stack' => 20
            ];
        }
        return $_;
    });
}