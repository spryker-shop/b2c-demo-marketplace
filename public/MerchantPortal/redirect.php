<?php

# The file is needed to allow redirects from 3rd party sites to the Merchant Portal. The default session cookie settings is SameSite=Strict and the browser does not allow to read session cookies.
# Using the intermediate page on the Merchant Portal domain, the session cookies are visible and a user can continue with his session.
if (empty($_GET['url'])) {
    exit('No redirect URL provided');
}
if (empty(filter_var($_GET['url'], FILTER_SANITIZE_URL))) {
    exit('No redirect URL provided');
}

?>
<p style="text-align: center">
    The site <?php echo filter_var($_SERVER['HTTP_REFERER'] ?? '', FILTER_SANITIZE_URL); ?> wants to redirect you to <strong><?php echo filter_var($_GET['url'], FILTER_SANITIZE_URL) ?></strong>. Would you like to follow the redirect?
</p>
<p style="text-align: center">
    <a href="<?php echo filter_var($_GET['url'], FILTER_SANITIZE_URL); ?>">Follow</a>
</p>
