<?php

# The file is needed to allow redirects from 3rd party sites to the Merchant Portal. The default session cookie settings is SameSite=Strict and the browser does not allow to read session cookies.
# Using intermediate page on the Merchant Portal domain, the session cookies are visible and a user can continue with his session.
if (empty($_GET['url'])) {
    exit('No redirect URL provided');
}
?>
<p style="text-align: center">
    The site <?php echo htmlspecialchars($_SERVER['HTTP_REFERER'], ENT_QUOTES, 'UTF-8') ?? ''; ?> wants to redirect you to <strong><?php echo htmlspecialchars($_GET['url'], ENT_QUOTES, 'UTF-8'); ?></strong>. Do you want to follow the redirect?
</p>
<p style="text-align: center">
    <a href="<?php echo htmlspecialchars($_GET['url'], ENT_QUOTES, 'UTF-8'); ?>">Follow</a>
</p>
