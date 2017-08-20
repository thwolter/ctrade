<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Error pages messages
    |--------------------------------------------------------------------------
    |
    |
    */

    'goto' => 'Zur Homepage',
    'report' => 'Problem melden',

    'default' => [
        'title' => 'Oops, the page you\'re looking for does not exist.',
        'message' => 'Go back to the previous page and try again. 
                    If you think something is broken, report a problem.'
    ],
    '400' => [
        'title' => 'We\'ve got some trouble | 400 - Bad Request.',
        'message' => 'The server cannot process the request due to something that is perceived to be a client error.'
    ],
    '401' => [
        'title' => 'We\'ve got some trouble | 401 - Unauthorized.',
        'message' => 'The requested resource requires an authentication.'
    ],
    '403' => [
        'title' => 'We\'ve got some trouble | 403 - Access Denied.',
        'message' => 'The requested resource requires an authentication.'
    ],
    '404' => [
        'title' => 'Sorry, diese Seite existiert leider nicht.',
        'message' => 'Du kannst zur Homepage zurück gehen oder uns ein Problem melden.'
        ],
    '500' => [
        'title' => 'Webservice currently unavailable.',
        'message' => 'An unexpected condition was encountered.
                    Our service team has been dispatched to bring it back online.'
    ],
    '503' => [
        'title' => 'Looks like we\'re having some server issues.',
        'message' => 'Go back to the previous page and try again.
                    If you think something is broken, report a problem.'
    ]


];
