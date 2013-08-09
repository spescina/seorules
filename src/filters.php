<?php

Route::filter('seorules.before', function() {
    
    Seo::init();
    
});

Route::filter('seorules.after', function() {
    
    Seo::prepareRule();
    
});
