<?php

// Get URL and parse the name
$base_url = $actual_link = $_SERVER[HTTP_HOST];
$actual_url = $_SERVER[REQUEST_URI];
$page_reuest = str_replace('/','',$actual_url);

// call the page by the name instead of ID
echo 'You requested: '.$page_reuest;
