<?php

require 'php/classes/resources.php';

echo Template::render(
    'static/esplora.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => Template::render('static/layout/header.html',[]),
        'footer' => Template::render('static/layout/footer.html',[]),
        'new_arrivals_vinyls' => '<p>TBD - TEMPORANEO - DA IMPLEMENTARE</p>',
        'loved_artists' => '<p>TBD - TEMPORANEO - DA IMPLEMENTARE</p>',
        'most_collected_vinyls' => '<p>TBD - TEMPORANEO - DA IMPLEMENTARE</p>',
        'top_rated_vinyls' => '<p>TBD - TEMPORANEO - DA IMPLEMENTARE</p>'
    ]
);
