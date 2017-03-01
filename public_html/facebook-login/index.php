<?php
//TODO: replace app_id and app_secret with
$fb = new Facebook\Facebook([
'app_id' => '{app-id}', // Replace {app-id} with your app id
'app_secret' => '{app-secret}',
'default_graph_version' => 'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
//TODO change the url to actual api url
$loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';