<?php

Route::filter('seorules.before', function() {
    
    Seo::init();
    
});
