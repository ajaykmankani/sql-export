<?php 
// Database configuration    
define('DB_HOST', 'localhost'); 
define('DB_USERNAME', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'test'); 
 
// Google API configuration 
define('GOOGLE_CLIENT_ID', '120136095373-drl3g096q612buq3rd03d300180etfhd.apps.googleusercontent.com'); 
define('GOOGLE_CLIENT_SECRET', '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'); 
define('GOOGLE_OAUTH_SCOPE', 'https://www.googleapis.com/auth/drive'); 
define('REDIRECT_URI', 'https://addurl.ink/ajay-developer/sql-export/google_drive_sync.php'); 
 
// Start session 
if(!session_id()) session_start(); 
 
// Google OAuth URL 
$googleOauthURL = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode(GOOGLE_OAUTH_SCOPE) . '&redirect_uri=' . REDIRECT_URI . '&response_type=code&client_id=' . GOOGLE_CLIENT_ID . '&access_type=online'; 
 
?>