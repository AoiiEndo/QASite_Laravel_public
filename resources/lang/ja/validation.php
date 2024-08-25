<?php

return [
    'custom' => [
        'target_score' => [
            'required' => ':attribute は必須です。',
            'integer' => '目標得点は整数でなければなりません。',
            'min' => '目標得点は :min 以上でなければなりません。',
            'max' => '目標得点は :max 以下でなければなりません。',
        ],
        'actual_score' => [
            'integer' => '結果得点は整数でなければなりません。',
            'min' => '結果得点は :min 以上でなければなりません。',
            'max' => '結果得点は :max 以下でなければなりません。',
        ],
        'test_name' => [
            'required' => ':attribute は必須です。',
            'unique' => '":input" はすでに登録されています。',
        ],
        'category_name' => [
            'required' => ':attribute は必須です。',
            'unique' => '":input" はすでに登録されています。',
        ]
    ],
];