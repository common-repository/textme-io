<?php
/**
 * Plugin Name: TextMe.io Wordpress Plugin
 * Plugin URI: http://textme.io
 * Description: This plugin adds TextMe.io shortcodes.
 * Version: 1.1.0
 * Author: Terry Godier
 * Author URI: http://textme.io
 * License: GPL2
 */


// register settings
add_action( 'admin_init', 'textme_settings' );

function textme_settings() {
    register_setting( 'textme-settings-group', 'textme_account_id' );
    register_setting('textme-settings-group', 'textme_embed_style'); 
    
}



// settings page
add_action('admin_menu', 'textme_menu');

function textme_menu() {
    add_menu_page('TextMe.io Settings', 'TextMe.io', 'administrator', 'textme-settings', 'textme_settings_page', 'dashicons-admin-generic');
}

function textme_settings_page() {
  // 
?>
<div class="wrap">
<h2>Account Details</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'textme-settings-group' ); ?>
    <?php do_settings_sections( 'textme-settings-group' ); ?>
    <p>It's super easy to integrate TextMe.io into your wordpress site. Simply <a href="http://textme.io/users/login" target="_blank">login to TextMe</a> and grab your user id and paste it below. </p>
    <p>Once you're done - simply copy and paste this shortcode wherever you want the form to display (pages, posts, widgets, etc): <b>[textme]</b>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Account ID</th>
        <td><input type="text" name="textme_account_id" value="<?php echo esc_attr( get_option('textme_account_id') ); ?>" /></td>
        </tr>
    </table>
<input type="radio" name="textme_embed_style" value="blue" <?php if (get_option('textme_embed_style') == 'blue'){ echo 'checked';} ?>> <img src='https://d2dndvdjs7450b.cloudfront.net/txtme_blue.png'  style='margin-top:30px;' /> <br>  

<input type="radio" name="textme_embed_style" value="black" <?php if (get_option('textme_embed_style') == 'black'){ echo 'checked';} ?>> <img src='https://d2dndvdjs7450b.cloudfront.net/txtme_black.png'  style='margin-top:30px;' /> <br>  
    

<input type="radio" name="textme_embed_style" value="grey" <?php if (get_option('textme_embed_style') == 'grey'){ echo 'checked';} ?>> <img src='https://d2dndvdjs7450b.cloudfront.net/txtme_grey.png'  style='margin-top:30px;' /> <br>  
    
    <?php submit_button(); ?>

</form>
</div>
<?php 

}

// Register style sheet.
add_action( 'wp_enqueue_scripts', 'register_textme_styles' );

/**
 * Register style sheet.
 */
function register_textme_styles() {
    wp_register_style( 'textme_io', plugins_url( 'textme_io/plugin.css' ) );
    wp_enqueue_style( 'textme_io' );
}

// register the shortcode
function textme_form(){

?>
<!--- Begin TextMe.io Widget -->
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://d2dndvdjs7450b.cloudfront.net/txtme.js"></script>
<script>
$( document ).ready(function() {
  $('a.txtmebutton').webuiPopover();
});
</script>  
<a href="#" class="txtmebutton txtbtn txtbtn-default bottom-right" data-placement="bottom-right" 
                                    data-content="<script>var frm = $('#txtmeForm');frm.submit(function (ev) {$.ajax({type: frm.attr('method'),url: frm.attr('action'),data: frm.serialize(),success: function (data) {$('#txtmeForm').hide();$('#txtsuccess').show();}});ev.preventDefault();});</script><form class='txtmeform' id='txtmeForm' method='post' action='http://textme.io/t/<?php echo esc_attr( get_option('textme_account_id') ); ?>'><p>Enter your phone number below to get an instant text with our details.</p><input type='text' name='number' placeholder='Enter Phone Number...' pattern='\d*'><input type='submit' class='txtmeform' value='Send Now!' id='submitBut'></form><p id='txtsuccess' style='display:none;'>Thanks! Your message should be arriving right about.... now.</p>" ><img src='https://d2dndvdjs7450b.cloudfront.net/txtme_<?php echo get_option('textme_embed_style'); ?>.png' /></a>
  
<!-- End TextMe.io --> 

<?php
}
add_shortcode('textme', 'textme_form');
?>