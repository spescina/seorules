<?php

Route::filter('seorules.seo', function() {
    
    Seo::start();
    
});
