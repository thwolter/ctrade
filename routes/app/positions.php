<?php

// Position resources
Route::resource('/portfolios/{portfolio}/positions', 'PositionsController',
    ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

