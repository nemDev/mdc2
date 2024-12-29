<?php

return [
    'orders' => [
        'label' => 'Import orders',
        'permission_required' => 'import-orders',
        'files' => [
            'file1' => [
                'label' => 'File 1',
                'header_to_db' => [
                    'order_date' => [
                        'label' => 'Order Date',
                        'type' => 'date',
                        'validation' => ['required']
                    ],
                    'channel' => [
                        'label' => 'Channel',
                        'type' => 'string',
                        'validation' => ['required', 'in' => ['PT', 'Amazon', 'eBay']]
                    ],
                    'sku' => [
                        'label' => 'SKU',
                        'type' => 'string',
                        'validation' => ['required', 'exists' => ['table' => 'products_file1', 'column' => 'sku']]
                    ],
                    'item_description' => [
                        'label' => 'Item Description',
                        'type' => 'string',
                        'validation' => ['nullable']
                    ],
                    'origin' => [
                        'label' => 'Origin',
                        'type' => 'string',
                        'validation' => ['required']
                    ],
                    'su_num' => [
                        'label' => 'SO#',
                        'type' => 'string',
                        'validation' => ['required']
                    ],
                    'cost' => [
                        'label' => 'Cost',
                        'type' => 'double',
                        'validation' => ['required']
                    ],
                    'shipping_cost' => [
                        'label' => 'Shipping Cost',
                        'type' => 'double',
                        'validation' => ['required']
                    ],
                    'total_price' => [
                        'label' => 'Total Price',
                        'type' => 'double',
                        'validation' => ['required']
                    ]
                ],
                'update_or_create' => ['su_num', 'sku']
            ],
            'file2' => [
                'label' => 'File 2',
                'header_to_db' => [
                    'order_date' => [
                        'label' => 'Order Date',
                        'type' => 'date',
                        'validation' => ['required']
                    ],
                    'channel' => [
                        'label' => 'Channel',
                        'type' => 'string',
                        'validation' => ['required', 'in' => ['PT', 'Amazon']]
                    ],
                    'sku' => [
                        'label' => 'SKU',
                        'type' => 'string',
                        'validation' => ['required']
                    ],
                    'origin' => [
                        'label' => 'Origin',
                        'type' => 'string',
                        'validation' => ['required']
                    ],
                    'su_num' => [
                        'label' => 'SO#',
                        'type' => 'string',
                        'validation' => ['required']
                    ],
                    'cost' => [
                        'label' => 'Cost',
                        'type' => 'double',
                        'validation' => ['required']
                    ],
                    'shipping_cost' => [
                        'label' => 'Shipping Cost',
                        'type' => 'double',
                        'validation' => ['required']
                    ],
                    'total_price' => [
                        'label' => 'Total Price',
                        'type' => 'double',
                        'validation' => ['required']
                    ],
                    'notes' => [
                        'label' => 'Notes',
                        'type' => 'string',
                        'validation' => ['required']
                    ],
                ],
                'update_or_create' => ['su_num', 'sku']
            ]
        ]
    ],
    'products' => [
        'label' => 'Import products',
        'permission_required' => 'import-products',
        'files' => [
            'file1' => [
                'label' => 'File 1',
                'header_to_db' => [
                    'name' => [
                        'label' => 'Name',
                        'type' => 'string',
                        'validation' => ['required']
                    ],
                    'sku' => [
                        'label' => 'SKU',
                        'type' => 'string',
                        'validation' => ['required']
                    ],
                    'description' => [
                        'label' => 'Description',
                        'type' => 'string',
                        'validation' => ['nullable']
                    ]
                ],
                'update_or_create' => ['sku']
            ]
        ]
    ]
];
