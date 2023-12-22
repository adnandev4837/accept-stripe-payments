<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	//Development>Wesite>CMS>Wordpress
    $publishableKey = sanitize_text_field($_POST["publishableKey"]);
    $secretKey = sanitize_text_field($_POST["secretKey"]);
    $thankYouPageUrl = sanitize_text_field($_POST["thankYouPageUrl"]);
    $cancelPageUrl = sanitize_text_field($_POST["cancelPageUrl"]);
    update_option( 'publishable_key', $publishableKey ); 
    update_option( 'secret_key', $secretKey ); 
    update_option( 'thank_you_page_url', $thankYouPageUrl ); 
    update_option( 'cancel_page_url', $cancelPageUrl ); 
    add_action( 'admin_notices', 'admin_notice__success' );
  }
function admin_notice__success() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'Success! setting saved successfully', TEXT_DOMAIN ); ?></p>
    </div>
    <?php
  }
  do_action( 'admin_notices' );
?>
<form action="" id="form-admin" class="form-sett" method="POST" >
  <h2>General Settings<hr></h2>
  <div class="stripe-flex">
  <label for="publishable-key-label" class="publishable-key-label">Publishable Key</label>
  <input type="text" id="publishable-key" name="publishableKey"  class="publishable-key" placeholder="Publishable Key" value="<?php if(!empty(get_option( 'publishable_key' ))){ echo get_option( 'publishable_key' );}else {echo '';} ?>"></div>
  <div class="stripe-flex">
  <label for="secret-key-label" class="secret-key-label">Secret Key</label>
  <input type="text" id="secret-key" name="secretKey"  class="secret-key" placeholder="Secret Key" value="<?php if(!empty(get_option( 'secret_key' ))){ echo get_option( 'secret_key' );}else {echo '';} ?>">
</div>
<div class="stripe-flex">
  <label for="thank-you-page-url-label" class="thank-you-page-url-label">Thank You Page URL</label>
  <input type="text" id="thank-you-page-url" name="thankYouPageUrl"  class="thank-you-page-url" placeholder="Thank You Page Url" value="<?php if(!empty(get_option( 'thank_you_page_url' ))){ echo get_option( 'thank_you_page_url' );}else {echo '';} ?>">
</div>
<div class="stripe-flex">
  <label for="cancel-page-url-label" class="cancel-page-url-label">Cancel Page URL</label>
  <input type="text" id="cancel-page-url" name="cancelPageUrl"  class="cancel-page-url" placeholder="Cancel Page Url" value="<?php if(!empty(get_option( 'cancel_page_url' ))){ echo get_option( 'cancel_page_url' );}else {echo '';} ?>">
</div>
<br>
<input type="submit" class="button btn-sett" name="submit" value="Save Settings" >
    </form>