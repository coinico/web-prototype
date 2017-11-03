<?php

return [

    [
        'color' => 'primary',
        'icon' => 'envelope',
        'model' => \App\Models\Contact::class,
        'name' => 'admin.new-messages',
        'url' => 'admin/contacts?new=on',
    ],
    [
        'color' => 'green',
        'icon' => 'user',
        'model' => \App\Models\User::class,
        'name' => 'admin.new-registers',
        'url' => 'admin/users?new=on',
    ],
    [
        'color' => 'yellow',
        'icon' => 'home',
        'model' => \App\Models\Property::class,
        'name' => 'admin.new-properties',
        'url' => 'admin/properties?new=on',
    ]

];