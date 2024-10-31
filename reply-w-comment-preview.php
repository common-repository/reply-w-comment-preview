<?php
/*
Plugin Name: @Reply \w comment preview
Description: Preview comments linked by @Reply plugin -- MASHUP of this: http://www.spreeblick.com/2007/09/25/worst-code-ever/ and that: http://wordpress.org/extend/plugins/reply-to/
Author: Marcus Himmel
Version: 0.0.41
Author URI: http://acidchaos.de
Plugin URI: http://blog.acidchaos.de/reply-w-comment-preview/
*/

$atrwcp_friggin_global_flag_for_jquery = true;

function atrwcp_load_jquery() {
    global $atrwcp_friggin_global_flag_for_jquery;
    wp_enqueue_script('jquery');
/*    if(function_exists('wp_enque_script'))
    {
		$atrwcp_friggin_global_flag_for_jquery = true;
    }
    else
    {
		$atrwcp_friggin_global_flag_for_jquery = false;
    }
*/
}

function atrwcp_build_head() {
    global $atrwcp_friggin_global_flag_for_jquery;
    if(!$atrwcp_friggin_global_flag_for_jquery)
    {
	?>
		<script type="application/javascript" src="<?php echo WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)).'/js/jquery-1.2.6.min.js?ver=1.2.6'; ?>" ></script>
	<?php
    }
    echo '<link media="screen" type="text/css" href="'.WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)).'/css/at-reply.css" rel="stylesheet">';
    $custcss = get_option( 'at_reply_with_preview_custom_css' );
    if(trim($custcss) != '')
	echo '<style type="text/css" media="screen">'.$custcss.'</style>';
}

function atrwcp_reply_js()
{
    	$comid = get_option( 'at_reply_with_preview_comment_textarea_id' );
        $comid = trim($comid);
        if($comid == '')
	    $comid = 'comment';
?>
    <script type="text/javascript">
    //<![CDATA[

    var myJQ = jQuery.noConflict();

    function atr_replyTo(commentID,author) {
	var inReplyTo='@<a href="#comment-'+commentID+'">'+author+'</a>: ';
    	var myField = myJQ('#<?php echo $comid; ?>').get(0);
        if (!myField) {
    		return false;
    	}
    	if (document.selection) {
    		myField.focus();
    		sel = document.selection.createRange();
    		sel.text = inReplyTo;
    		myField.focus();
    	}
    	else if (myField.selectionStart || myField.selectionStart == '0') {

    		var startPos = myField.selectionStart;
    		var endPos = myField.selectionEnd;
    		var cursorPos = endPos;
    		myField.value = myField.value.substring(0, startPos)
    					  + inReplyTo
    					  + myField.value.substring(endPos, myField.value.length);
    		cursorPos += inReplyTo.length;
    		myField.focus();
    		myField.selectionStart = cursorPos;
    		myField.selectionEnd = cursorPos;
    	}
    	else {
    		myField.attr("value", myField.attr("value") + inReplyTo);
    		myField.focus();
    	}
     }
     
    <?php
	$comdiv = get_option( 'at_reply_with_preview_comment_div_class' );
        $comdiv = trim($comdiv);
        if($comdiv == '')
	    $comdiv = 'comment-text';
    ?>
        
    myJQ(function(){
            var theLinks = myJQ('a.atr_link');
            theLinks.hover(function() {
                    myJQ('div#atr_tt').remove();
                    var c = myJQ('<div>').append(myJQ(myJQ(this).attr('href') + ' .<?php echo $comdiv; ?>').html());
                    var tt = myJQ('<div id="atr_tt">').empty().append(c).css('left', this.offsetLeft -15 + 'px').css('top', this.offsetTop + 19 + 'px').hide();
                    tt.appendTo(myJQ(this).parent());
                    tt.fadeIn("fast");
            }, function() {
                    myJQ('div#atr_tt').fadeOut("fast",function(){ myJQ('div#atr_tt').remove(); } );
            });
    } );

    //]]>
    </script>

<?php
}


function atrwcp_append_reply($input)
{
    $bar =$input . 'FOOObar';
    return $bar;
}


function atrwcp_reply($text = '', $before = '', $after = '')
{
echo $before;
?><span class="atr_reply" onclick='atr_replyTo("<?php comment_ID() ?>", "<?php comment_author();?>")' title="Reply to this comment"><?php
echo $text;
?><img class="atr_reply_img" alt="Reply to this comment" src="<?php echo WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__));?>/reply.png" /></span><?php
echo $after;
}

function atrwcp_repair_link($content) {
    $href = 'href="#comment-';
    $text = ' class="atr_link" ';
    
    return str_replace($href, $text . $href, $content);
}
 
 
 function atrwcp_admin()
 {
?>
    <div class="wrap">  
<?php

 // header
 echo "<h2>" . __( '@Reply \w comment preview', 'atr_trans_domain' ) . "</h2>";

 // options form    
?>

<form method="post" action="options.php">

<?php wp_nonce_field('update-options'); ?>

<input type="hidden" name="action" value="update" />

<input type="hidden" name="page_options" value="at_reply_with_preview_comment_div_class, at_reply_with_preview_commentmeta_div_class, at_reply_with_preview_custom_css, at_reply_with_preview_comment_textarea_id" />

<table class="form-table">
<tbody>
  
<tr valign="top">
<th scope="row"><label for="at_reply_with_preview_comment_div_class"><?php _e("CSS-class of the DIV containing the comments' text", 'atr_trans_domain' ); ?></label></th>
<td>
<input name="at_reply_with_preview_comment_div_class" id="at_reply_with_preview_comment_div_class" value="<?php echo get_option( 'at_reply_with_preview_comment_div_class' ); ?>" size="60" type="text">
<br/>
<?php _e("(optional, default is 'comment-text')", 'atr_trans_domain' ); ?>
</td>
<td></td>
</tr>

<tr valign="top">
<th scope="row"><label for="at_reply_with_preview_comment_textarea_id"><?php _e("ID of the comment form textarea", 'atr_trans_domain' ); ?></label></th>
<td>
<input name="at_reply_with_preview_comment_textarea_id" id="at_reply_with_preview_comment_textarea_id" value="<?php echo get_option( 'at_reply_with_preview_comment_textarea_id' ); ?>" size="60" type="text">
<br/>
<?php _e("(optional, default is 'comment')", 'atr_trans_domain' ); ?>
</td>
<td></td>
</tr>

<!--
<tr valign="top">
<th scope="row"><label for="at_reply_with_preview_commentmeta_div_class"><?php _e("CSS-class of the DIV containing the comments' meta data", 'atr_trans_domain' ); ?></label></th>
<td>
<input name="at_reply_with_preview_commentmeta_div_class" id="at_reply_with_preview_commentmeta_div_class" value="<?php echo get_option( 'at_reply_with_preview_commentmeta_div_class' ); ?>" size="60" type="text">
<br/>
<?php _e("(optional, default is 'commentmeta'; not used if you manually insert the code)", 'atr_trans_domain' ); ?>
</td>
<td></td>
</tr>
-->
<input name="at_reply_with_preview_commentmeta_div_class" value="" type="hidden">
    
<tr valign="top">
<th scope="row"><label for="at_reply_with_preview_custom_css"><?php _e("Custom CSS", 'atr_trans_domain' ); ?></label></th>
<td>
<textarea name="at_reply_with_preview_custom_css" id="at_reply_with_preview_custom_css" cols="60" rows="6"><?php echo get_option( 'at_reply_with_preview_custom_css' ); ?></textarea>
<br/>
<?php _e("I sure hope you know what yer doing!", 'atr_trans_domain' ); ?>
</td>
<td>interesting CSS-properties are:<pre>.atr_reply
.atr_reply:hover
.atr_reply_img
a.atr_link
a.atr_link:hover
div#atr_tt</pre>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="at_reply_with_preview_custom_css"><?php _e("Code to input into template:", 'atr_trans_domain' ); ?></label></th>
<td colspan="2">
<pre>&lt;?php if( function_exists( 'atrwcp_reply' ) ) atrwcp_reply( $text, $before, $after ); ?&gt;</pre>
The <em>strings</em> $text, $before, $after are <strong>optional</strong>.
<br/><br/>
<strong>Example:</strong>
<pre>&lt;?php if( function_exists( 'atrwcp_reply' ) ) atrwcp_reply( 'reply', '--' ); ?&gt;</pre>
results in: <?php if( function_exists( 'atrwcp_reply' ) ) atrwcp_reply( 'reply', '--' ); ?>
</td>
</tr>

</tbody>
</table>

<p class="submit"> <input type="submit" name="Submit" value="<?php _e('Update Options', 'atr_trans_domain' ) ?>" /> </p>

</form> </div>

<?php
} //END of atr_admin

function atrwcp_add_menu() {
    add_options_page('@Reply with comment preview', '@Reply with preview', 8, __FILE__, 'atrwcp_admin');
}

add_action('template_redirect', 'atrwcp_load_jquery');
add_action('wp_head', 'atrwcp_build_head');
add_action('comment_form', 'atrwcp_reply_js');
add_action('admin_menu', 'atrwcp_add_menu');

add_filter('comment_text', 'atrwcp_repair_link')
//add_filter('', 'atrwcp_append_reply');

?>