<?php

require 'php/classes/resources.php';

/* Load and render the head template with dynamic values */
$head = (new Head(
    'Vinyl Vault - Home',
    'Discover and collect vinyl records from around the world.',
    'vinyl, records, music, collection'
))->render();

/* Load and render the header template */
$header = (new Header())->render();

/* Output the complete HTML page */
echo Template::render(
    '../../index.html',
    [
        'head' => $head,
        'header' => $header,
        'content' => '<main><h2>Welcome to Vinyl Vault</h2><p>Your gateway to the world of vinyl records.</p></main>'
    ]
);