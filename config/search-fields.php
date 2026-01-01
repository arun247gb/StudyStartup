<?php

return [

    'ss_studies' => [
        'name',
        'protocol_number',
        ['with-search' => 'site.name'],  
        ['with-search' => 'organization.name'], 
    ],

    'ss_study_staffs' => [
        'name',
        'description',
        ['with-search' => 'user.name'],
        ['with-search' => 'study.name'], 
        ['with-search' => 'organization.name'],
    ],

];
