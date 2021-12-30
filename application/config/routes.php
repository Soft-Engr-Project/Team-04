<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route["comments/reaction"] = "comments/reaction";
$route["comments/cancel_update"] = "comments/cancel_update";
$route["comments/update"] = "comments/update";
$route["comments/delete"] = "comments/delete";
$route["comments/create"] = "comments/create";
$route["comments/fetch"] =  "comments/fetch";
$route["comments/edit"] =  "comments/edit";
$route["profiles"] = "profiles/view";
$route["profileposts/(:any)"] = "profileposts/view/$1";
$route["pages/view/profile"]="profiles/view";
$route["Signup/register"] = "Signup/register";
$route['posts/update']="posts/update";
$route['posts/create']="posts/create";
$route['posts/report_post_info'] = 'posts/report_post_info';
$route["posts/reports"] = "posts/reports";
$route['posts/(:any)']="posts/view/$1";
// $route['posts']='posts/index';
// $route['default_controller'] = 'pages/view';
$route['default_controller'] = 'logins/form';
//$route["(:any)"] ="pages/view/$1"meaning anything na kasama ni foldername/ which is eto pages/view/$1(means any)
$route["pages"]= "pages/view";
$route["pages/view/(:any)"]="pages/view/$1";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

