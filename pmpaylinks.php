<?php
/*
Plugin Name: PM Pay Links
Plugin URI: https://www.pmpaylinks.site
Description: Create Your Choice Of Short Tags To Generate PayPal Payment Links (Buy Now, Recurring & Trial With Recurring) For Quick & Easy Payments, Also Redirect To Your Choice Of URL Upon Payment Confirmation & Cancellation
Version: 1.0.0
Author: PM Pay Links Team
Author URI: https://www.pmpaylinks.site
License: GPL2
*/
/*  Copyright 2021 PM Pay Links Team (email : support@pmpaylinks.site)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


global $wpdb;

add_action('admin_menu', 'pmpaylinks_top_menu');

function pmpaylinks_top_menu() {
add_menu_page('PM Pay Links', 'PMPayLinks', 'read', 'pmpaylinks_main_sl', 'pmpaylinks_mainpage', plugin_dir_url( __FILE__ ) . '/pmpaylinksicon.png');
add_submenu_page('pmpaylinks_main_sl','PM Pay Links', 'Introduction', 'read', 'pmpaylinks_main_sl', 'pmpaylinks_mainpage');
add_submenu_page('pmpaylinks_main_sl','Create PMPayLinks', 'Create', 'read', 'pmpaylinks_createlink_sl', 'pmpaylinks_createlinkpage');
add_submenu_page('pmpaylinks_main_sl','List All PMPayLinks', 'List', 'read', 'pmpaylinks_listlink_sl', 'pmpaylinks_listlinkpage');
add_submenu_page('pmpaylinks_main_sl','Help', 'Help', 'read', 'pmpaylinks_help_sl', 'pmpaylinks_helppage');
}

function pmpaylinks_mainpage() {
global $wpdb;
$blogurl = get_bloginfo ( 'wpurl' );
$pmmainurl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_main_sl";
$pmcreateurl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_createlink_sl";
$pmlisturl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_listlink_sl";
$pmhelpurl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_help_sl";
?>
<p align="center"><a href="https://www.pmpaylinks.site" target=_blank><img src="<?php echo(plugin_dir_url( __FILE__ )); ?>/pmpaylinkstopbanner.png"></a></p>
<div align="center" style="background-color: #ffdbf6;width: auto;border: 5px solid black;padding: 50px;margin: 20px;">
<h1 align="center">PMPayLinks</h1>
<b>Thank you for installing this plugin & supporting us</b>.
<br><br>This plugin allows you to generate short code tags which if placed anywhere on your site pages will help you generate PayPal payment links.<br>
Payment links could be of any type - buy now, recurring & trial with recurring payments.<br>
This plugin also gives you ability to redirect customers to your choice of URL after payment is done or cancelled.
<br><br>Visit <a href="https://www.pmpaylinks.site" target=_blank>plugin website</a> to read all about plugin, see demo & find help for customization.
<br><br><a href="<?php echo esc_url($pmcreateurl); ?>"><button type="button">Create PM Pay Links</button></a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href="<?php echo esc_url($pmlisturl); ?>"><button type="button">List All PM Pay Links</button></a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href="<?php echo esc_url($pmhelpurl); ?>"><button type="button">Help</button></a>

<br><br><br><strong>Do you want to automatically fulfill orders (send an automatic email or send IPN to some web service after PayPal confirms the payment)?</strong> 
<br>If so, click on the banner below to purchase the PMPayLinks Pro plugin and set up auto fulfillment on every PMPayLink you create.
<br><br>Users love our PRO version for the ability to set IPN to notify any other web service of PayPal payment & our all women friendly support team even help set it up if required.
<br>Also pro version gives you ability to select your choice of currency for PayPal payment which is only USD for this plugin.
<br><br>
<a href="https://www.pmpaylinks.site" target=_blank><img src="<?php echo(plugin_dir_url( __FILE__ )); ?>/pmpaylinksprobanner.png" style="height:auto;max-width:100%;border:none;display:block;" alt="Upgrade To Pro Today"></a>
<br><br>
For any help or customization in the plugin, feel free to email us at support@pmpaylinks.site<br>
<br>
</div>
<p align="center"><a href="https://www.pmpaylinks.site" target=_blank><img src="<?php echo(plugin_dir_url( __FILE__ )); ?>/logo.png"></a></p>
<?php
}

function pmpaylinks_createlinkpage() {
global $wpdb;
$blogurl = get_bloginfo ( 'wpurl' );
$pmmainurl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_main_sl";
$pmcreateurl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_createlink_sl";
$pmlisturl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_listlink_sl";
$pmhelpurl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_help_sl";
	
if (!empty($_POST))
{
$linkid = sanitize_text_field( $_POST['linkid'] );
$linkshorttag = sanitize_text_field( $_POST['linkshorttag'] );
$linktext = sanitize_text_field( $_POST['linktext'] );
$currency = sanitize_text_field( $_POST['currency'] );
$paypalemail = sanitize_email( $_POST['paypalemail'] );
$productname = sanitize_text_field( $_POST['productname'] );
$thanksurl = esc_url_raw( $_POST['thanksurl'] );
$cancelurl = esc_url_raw( $_POST['cancelurl'] );
$paylinktype = sanitize_text_field( $_POST['paylinktype'] );
$buynowprice = sanitize_text_field( $_POST['buynowprice'] );
$trialprice = sanitize_text_field( $_POST['trialprice'] );
$trialperiod = sanitize_text_field( $_POST['trialperiod'] );
$trialrecurprice = sanitize_text_field( $_POST['trialrecurprice'] );
$trialrecurperiod = sanitize_text_field( $_POST['trialrecurperiod'] );
$trialrecurnumber = sanitize_text_field( $_POST['trialrecurnumber'] );
$recurprice = sanitize_text_field( $_POST['recurprice'] );
$recurperiod = sanitize_text_field( $_POST['recurperiod'] );
$recurnumber = sanitize_text_field( $_POST['recurnumber'] );


if($paylinktype!="" && isset($cancelurl) && !empty($cancelurl) && isset($thanksurl) && !empty($thanksurl) && isset($productname) && !empty($productname) && isset($linkid) && !empty($linkid) && isset($linkshorttag) && !empty($linkshorttag) && isset($linktext) && !empty($linktext) && isset($paypalemail) && !empty($paypalemail)) 
{
//check if link for short tag already exists
$myrow24 = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."pmpaylinksdata where linkshorttag = '".$linkshorttag."'" );
if($myrow24->linktext!="")
{
$pmppmsg = "Link for short tag ".esc_html($linkshorttag)." already exists, please check.";

}


        if($paylinktype=="buynow")
        {
        if($buynowprice!="" && is_numeric($buynowprice))
        {
	$sql1 = "INSERT INTO ".$wpdb->prefix."pmpaylinksdata (linkid, linkshorttag, linktext, currency, paypalemail, productname, thanksurl, cancelurl, paylinktype, buynowprice) values ('$linkid', '$linkshorttag', '$linktext', '$currency', '$paypalemail', '$productname', '$thanksurl', '$cancelurl', '$paylinktype', '$buynowprice')";
	$wpdb->query($sql1);
	}
	else
        {
        //redirect with buynowprice missing or non numeric error    
	$pmppmsg = "Buy Now Price Missing OR Non Numeric Value Entered, Please Check & Try Again.";
	
	}
        }
        elseif($paylinktype=="trialsubs")
        {
        if($trialprice!="" && is_numeric($trialprice) && $trialperiod!="" && is_numeric($trialperiod) && $trialrecurprice!="" && is_numeric($trialrecurprice) && $trialrecurperiod!="" && is_numeric($trialrecurperiod) && $trialrecurnumber!="" && is_numeric($trialrecurnumber))
        {
	$sql1 = "INSERT INTO ".$wpdb->prefix."pmpaylinksdata (linkid, linkshorttag, linktext, currency, paypalemail, productname, thanksurl, cancelurl, paylinktype, trialprice, trialperiod, trialrecurprice, trialrecurperiod, trialrecurnumber) values ('$linkid', '$linkshorttag', '$linktext', '$currency', '$paypalemail', '$productname', '$thanksurl', '$cancelurl', '$paylinktype', '$trialprice', '$trialperiod', '$trialrecurprice', '$trialrecurperiod', '$trialrecurnumber')";
	$wpdb->query($sql1);
	}
	else
        {
        //redirect with trial pricing missing or non numeric error    
	$pmppmsg = "Trial Price Fields Missing Input OR Non Numeric Values Entered, Please Check & Try Again.";
	
	}
        }
        elseif($paylinktype=="subs")
        {
        if($recurprice!="" && is_numeric($recurprice) && $recurperiod!="" && is_numeric($recurperiod) && $recurnumber!="" && is_numeric($recurnumber))
        {
	$sql1 = "INSERT INTO ".$wpdb->prefix."pmpaylinksdata (linkid, linkshorttag, linktext, currency, paypalemail, productname, thanksurl, cancelurl, paylinktype, recurprice, recurperiod, recurnumber) values ('$linkid', '$linkshorttag', '$linktext', '$currency', '$paypalemail', '$productname', '$thanksurl', '$cancelurl', '$paylinktype', '$recurprice', '$recurperiod', '$recurnumber')";
	$wpdb->query($sql1);
	}
	else
        {
        //redirect with subs pricing missing or non numeric error    
	$pmppmsg = "Recur Price Fields Missing Input OR Non Numeric Values Entered, Please Check & Try Again.";
	
	}
        }

	//success redirect
$pmppmsg = "PM Pay Link Successfully Created.";

}
else
{
//redirect with one or more missing parameters
$pmppmsg = "One of the fields are empty, please try again.";
}	
}
?>
<p align="center"><a href="https://www.pmpaylinks.site" target=_blank><img src="<?php echo(plugin_dir_url( __FILE__ )); ?>/pmpaylinkstopbanner.png"></a></p>
<div align="center" style="background-color: #ffdbf6;width: auto;border: 5px solid black;padding: 50px;margin: 20px;">
<h1 align="center">Create PM Pay Links</h2>
Please fill the form below completely to create a new PM Pay Link. 
<br>If you wish to edit one, click on "List All PM Pay Links" button below to check your existing links and edit them.
<br><br><strong>Create PM Pay Links</strong> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href="<?php echo esc_url($pmlisturl); ?>"><button type="button">List All PM Pay Links</button></a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href="<?php echo esc_url($pmhelpurl); ?>"><button type="button">Help</button></a>
<br><br>
<?php
if (!empty($_POST))
{
?>
<font color="green" size=4>
<?php echo esc_html($pmppmsg); ?><br><br>
</font>
<?php
}
?>
<form action="<?php echo esc_url($pmcreateurl); ?>" method="POST">
		    <strong>Link ID</strong><br>(for your reference)<br><input type="text" name="linkid"><br><br>
		    <strong>Short Tag</strong><br>(keep it unique, for example enter [paylinkformyebook1])<br><input type="text" name="linkshorttag"><br><br>
		    <strong>Link Text</strong><br>(what you want your link to say, example - Click Here To Pay)<br><input type="text" name="linktext"><br><br>
		    <strong>PayPal Email</strong><br>(where the payment should go)<br><input type="text" name="paypalemail"><br><br>
		    <strong>Select Payment Currency</strong> (<a href="https://www.pmpaylinks.site" target=_blank>Upgrade To Pro</a> To Select Your Choice Of Currency)<br>
                    <select id="currency" name="currency">
                        <option value="USD">US Dollar ($)</option>
                        </select>
                        <br><br>
					    <strong>Enter Product Name</strong><br><font size="2">As Shown On PayPal Payment Page</font><br><input type="text" name="productname" maxlength=127><br><br>
					    <strong>Enter Thanks URL</strong><br><font size="2">Where The Buyer Is Taken After Completing The Payment Process</font><br><input type="text" name="thanksurl"><br><br>
					    <strong>Enter Cancel URL</strong><br><font size="2">Where The Buyer Is Taken After Clicking Cancel During The Payment Process</font><br><input type="text" name="cancelurl"><br><br>

	  <strong>Fulfillment Type</strong>: <font size=2>How You Are Going To Fulfill The Order, That Is, Give Customer Access To Their Purchase.</font>
<br><strong><a href="https://www.pmpaylinks.site" target=_blank>Upgrade To Pro</a> To Automatically Fulfill Orders</strong>
   
<br><br>
Payment Type:
          <select id="paylinktype" name="paylinktype">
              
          <option value="">Please Select</option>
          
          <option value="buynow">One Time Buy Now</option>

          <option value="trialsubs">Trial With Subscription</option>

          <option value="subs">Recurring Subscription</option>

        </select>
<br><br>
<div id="buynow">
    Enter Buy Now Price: <br><input type="text" name="buynowprice"><br><br>
</div>

<div id="trialsubs">
    <font size=2><strong>Example:</strong> For A $1 Trial For 7 Days After Which You Wish To Charge $25 Every 30 Days For 3 Times (For Unlimited Charges Until Cancelled, Enter 0 Instead Of 3) Then Enter 1 In Trial Price, 7 In Trial Period, 25 In After Trial Price, 30 In Number Of Days For After Trial Price To Recur & 3 In Number Of Times After Price Should Recur. To Know More About This Option, <a href="https://www.pmpaylinks.site" target=_blank>Visit Plugin Website</a>.</font><br><br>
    Enter Trial Price: <br><input type="text" name="trialprice"><br><br>
    Enter Trial Period In Days (Between 1-90): <br><input type="text" name="trialperiod"><br><br>
    Enter After Trial Price: <br><input type="text" name="trialrecurprice"><br><br>
    Enter Number Of Days After Which The After Trial Price Should Recur (Between 1-90): <br><input type="text" name="trialrecurperiod"><br><br>
    Enter Number Of Times After Trial Price Should Recur: <br><input type="text" name="trialrecurnumber"><br><br>
</div>

<div id="subs">
    <font size=2><strong>Example:</strong> Enter 25, 30 & 3 In Below Boxes Respectively For Charging $25 Every 30 Days For 3 Times. For Unlimited Charges Until Cancelled, Enter 0 Instead Of 3. To Know More About This Option, <a href="https://www.pmpaylinks.site" target=_blank>Visit Plugin Website</a>.</font><br><br>
    Enter Recurring Price: <br><input type="text" name="recurprice"><br><br>
    Enter Number Of Days After Which The Charge Should Recur (Between 1-90): <br><input type="text" name="recurperiod"><br><br>
    Enter Number Of Times Charge Should Recur: <br><input type="text" name="recurnumber"><br><br>
</div>

<input type="submit" value="Create PMPayLink">
</form>

<br><br><br><strong>Do you want to automatically fulfill orders (send an automatic email or send IPN to some web service after PayPal confirms the payment)?</strong> 
<br>If so, click on the banner below to purchase the PMPayLinks Pro plugin and set up auto fulfillment on every PMPayLink you create.
<br><br>Users love our PRO version for the ability to set IPN to notify any other web service of PayPal payment & our all women friendly support team even help set it up if required.
<br>Also pro version gives you ability to select your choice of currency for PayPal payment.
<br><br>
<a href="https://www.pmpaylinks.site" target=_blank><img src="<?php echo(plugin_dir_url( __FILE__ )); ?>/pmpaylinksprobanner.png" style="height:auto;max-width:100%;border:none;display:block;" alt="Upgrade To Pro Today"></a>
<br><br>
For any help or customization in the plugin, feel free to email us at support@pmpaylinks.site
<br><br>
</div>
<p align="center"><a href="https://www.pmpaylinks.site" target=_blank><img src="<?php echo(plugin_dir_url( __FILE__ )); ?>/logo.png"></a></p>
<?php
wp_enqueue_script('jquery');
?>
<script>
    jQuery(document).ready(function($){

        $('#buynow').hide();
        $('#trialsubs').hide();
        $('#subs').hide();

$('#paylinktype').on('change', function() {
        var value = $(this).val();
        if(value == "buynow") {

        $('#buynow').show();
        $('#trialsubs').hide();
        $('#subs').hide();

        } else if(value == "trialsubs") {

        $('#trialsubs').show();
        $('#buynow').hide();
        $('#subs').hide();

        } else if(value == "subs") {

        $('#subs').show();
        $('#buynow').hide();
        $('#trialsubs').hide();

        }
        
        else {
        
        $('#buynow').hide();
        $('#trialsubs').hide();
        $('#subs').hide();

        }
        

    });
}); 
</script>
<?php
}


function pmpaylinks_listlinkpage() {
global $wpdb;
$blogurl = get_bloginfo ( 'wpurl' );
$pmmainurl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_main_sl";
$pmcreateurl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_createlink_sl";
$pmlisturl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_listlink_sl";
$pmhelpurl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_help_sl";
?>
<p align="center"><a href="https://www.pmpaylinks.site" target=_blank><img src="<?php echo(plugin_dir_url( __FILE__ )); ?>/pmpaylinkstopbanner.png"></a></p>
<div align="center" style="background-color: #ffdbf6;width: auto;border: 5px solid black;padding: 50px;margin: 20px;">
<?php
if($_GET['pmcm']=="del")
{
$dnumd = sanitize_text_field($_GET['dnumd']);
$sql1 = "DELETE FROM ".$wpdb->prefix."pmpaylinksdata WHERE datanumber = $dnumd";
$wpdb->query($sql1);
}

if($_GET['dnum']!="")
{
if (!empty($_POST))
{
$linkid = sanitize_text_field( $_POST['linkid'] );
$linkshorttag = sanitize_text_field( $_POST['linkshorttag'] );
$linktext = sanitize_text_field( $_POST['linktext'] );
$currency = sanitize_text_field( $_POST['currency'] );
$paypalemail = sanitize_email( $_POST['paypalemail'] );
$productname = sanitize_text_field( $_POST['productname'] );
$thanksurl = esc_url_raw( $_POST['thanksurl'] );
$cancelurl = esc_url_raw( $_POST['cancelurl'] );
$paylinktype = sanitize_text_field( $_POST['paylinktype'] );
$buynowprice = sanitize_text_field( $_POST['buynowprice'] );
$trialprice = sanitize_text_field( $_POST['trialprice'] );
$trialperiod = sanitize_text_field( $_POST['trialperiod'] );
$trialrecurprice = sanitize_text_field( $_POST['trialrecurprice'] );
$trialrecurperiod = sanitize_text_field( $_POST['trialrecurperiod'] );
$trialrecurnumber = sanitize_text_field( $_POST['trialrecurnumber'] );
$recurprice = sanitize_text_field( $_POST['recurprice'] );
$recurperiod = sanitize_text_field( $_POST['recurperiod'] );
$recurnumber = sanitize_text_field( $_POST['recurnumber'] );
$dnum = sanitize_text_field($_POST['dnum']);

if($paylinktype!="" && isset($cancelurl) && !empty($cancelurl) && isset($thanksurl) && !empty($thanksurl) && isset($productname) && !empty($productname) && isset($linkid) && !empty($linkid) && isset($linkshorttag) && !empty($linkshorttag) && isset($linktext) && !empty($linktext) && isset($paypalemail) && !empty($paypalemail)) 
{
$sql1 = "UPDATE ".$wpdb->prefix."pmpaylinksdata SET linkid = '$linkid', linkshorttag = '$linkshorttag', linktext = '$linktext', currency = '$currency', paypalemail = '$paypalemail', productname = '$productname', thanksurl = '$thanksurl', cancelurl = '$cancelurl', paylinktype = '$paylinktype', buynowprice = '$buynowprice', trialprice = '$trialprice', trialperiod = '$trialperiod', trialrecurprice = '$trialrecurprice', trialrecurperiod = '$trialrecurperiod', trialrecurnumber = '$trialrecurnumber', recurprice = '$recurprice', recurperiod = '$recurperiod', recurnumber = '$recurnumber' where datanumber = $dnum";
$wpdb->query($sql1);
	

	//success redirect
$pmppemsg = "Successfully Updated.";

}
else
{
//redirect with one or more missing parameters
$pmppemsg = "One of the fields are empty, please check and try again.";

}
}
$dnume = sanitize_text_field($_GET['dnum']);
$myrowedit = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."pmpaylinksdata where datanumber = ".$dnume."" );
$pmediturlpost = $pmlisturl."&dnum=".$dnume; 
?>
<h1 align="center">Edit PM Pay Link With Short Tag <?php echo esc_html($myrowedit->linkshorttag); ?></h1>
<br><br><strong><a href="<?php echo esc_url($pmcreateurl); ?>"><button type="button">Create PM Pay Links</button></a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href="<?php echo esc_url($pmlisturl); ?>"><button type="button">List All PM Pay Links</button></a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href="<?php echo esc_url($pmhelpurl); ?>"><button type="button">Help</button></a></strong>
<br><br>
<?php
if (!empty($_POST))
{
?>
<font color="green" size=4>
<?php echo esc_html($pmppemsg); ?><br><br>
</font>
<?php
}
?>
<form action="<?php echo esc_url($pmediturlpost); ?>" method="POST">
<input type="hidden" name="dnum" value="<?php echo esc_html($myrowedit->datanumber); ?>">
<input type="hidden" id="paylinktypeold" name="paylinktypeold" value="<?php echo esc_html($myrowedit->paylinktype); ?>">

		    <strong>Link ID</strong><br>(for your reference)<br><input type="text" name="linkid" value="<?php echo esc_html($myrowedit->linkid); ?>"><br><br>
		    <strong>Short Tag</strong><br>(keep it unique, for example enter [paylinkformyebook1])<br><input type="text" name="linkshorttag" value="<?php echo esc_html($myrowedit->linkshorttag); ?>"><br><br>
		    <strong>Link Text</strong><br>(what you want your link to say, example - Click Here To Pay)<br><input type="text" name="linktext" value="<?php echo esc_html($myrowedit->linktext); ?>"><br><br>
		    <strong>PayPal Email</strong><br>(where the payment should go)<br><input type="text" name="paypalemail" value="<?php echo esc_html($myrowedit->paypalemail); ?>"><br><br>
		    <strong>Select Payment Currency</strong> (<a href="https://www.pmpaylinks.site" target=_blank>Upgrade To Pro</a> To Select Your Choice Of Currency)<br>
                    <select id="currency" name="currency">
                        <option value="USD" <?php if($myrowedit->currency=="USD") echo "selected"; ?>>US Dollar ($)</option>
                        </select>
                        <br><br>
					    <strong>Enter Product Name</strong><br><font size="2">As Shown On PayPal Payment Page</font> <br><input type="text" name="productname" maxlength=127 value="<?php echo esc_html($myrowedit->productname); ?>"><br><br>
					    <strong>Enter Thanks URL</strong><br><font size="2">Where The Buyer Is Taken After Completing The Payment Process</font> <br><input type="text" name="thanksurl" value="<?php echo esc_url($myrowedit->thanksurl); ?>"><br><br>
					    <strong>Enter Cancel URL</strong><br><font size="2">Where The Buyer Is Taken After Clicking Cancel During The Payment Process</font><br><input type="text" name="cancelurl" value="<?php echo esc_url($myrowedit->cancelurl); ?>"><br><br>

 <strong>Fulfillment Type</strong>: <font size=2>How You Are Going To Fulfill The Order, That Is, Give Customer Access To Their Purchase.</font>
<br><strong><a href="https://www.pmpaylinks.site" target=_blank>Upgrade To Pro</a> To Automatically Fulfill Orders</strong>
<br><br>
<strong>Payment Type</strong><br>
          <select id="paylinktype" name="paylinktype">
              
          <option value="">Please Select</option>
          
          <option value="buynow" <?php if($myrowedit->paylinktype=="buynow") echo "selected"; ?>>One Time Buy Now</option>

          <option value="trialsubs" <?php if($myrowedit->paylinktype=="trialsubs") echo "selected"; ?>>Trial With Subscription</option>

          <option value="subs" <?php if($myrowedit->paylinktype=="subs") echo "selected"; ?>>Recurring Subscription</option>

        </select>
<br><br>
<div id="buynow">
    <strong>Enter Buy Now Price</strong><br><input type="text" name="buynowprice" value="<?php echo esc_html($myrowedit->buynowprice); ?>"><br><br>
</div>

<div id="trialsubs">
    <font size=2><strong>Example:</strong> For A $1 Trial For 7 Days After Which You Wish To Charge $25 Every 30 Days For 3 Times (For Unlimited Charges Until Cancelled, Enter 0 Instead Of 3) Then Enter 1 In Trial Price, 7 In Trial Period, 25 In After Trial Price, 30 In Number Of Days For After Trial Price To Recur & 3 In Number Of Times After Price Should Recur. To Know More About This Option, <a href="https://www.pmpaylinks.site" target=_blank>Visit Plugin Website</a>.</font><br><br>
    Enter Trial Price: <br><input type="text" name="trialprice" value="<?php echo esc_html($myrowedit->trialprice); ?>"><br><br>
    Enter Trial Period In Days (Between 1-90): <br><input type="text" name="trialperiod" value="<?php echo esc_html($myrowedit->trialperiod); ?>"><br><br>
    Enter After Trial Price: <br><input type="text" name="trialrecurprice" value="<?php echo esc_html($myrowedit->trialrecurprice); ?>"><br><br>
    Enter Number Of Days After Which The After Trial Price Should Recur (Between 1-90): <br><input type="text" name="trialrecurperiod" value="<?php echo esc_html($myrowedit->trialrecurperiod); ?>"><br><br>
    Enter Number Of Times After Trial Price Should Recur: <br><input type="text" name="trialrecurnumber" value="<?php echo esc_html($myrowedit->trialrecurnumber); ?>"><br><br>
</div>

<div id="subs">
    <font size=2><strong>Example:</strong> Enter 25, 30 & 3 In Below Boxes Respectively For Charging $25 Every 30 Days For 3 Times. For Unlimited Charges Until Cancelled, Enter 0 Instead Of 3. To Know More About This Option, <a href="https://www.pmpaylinks.site" target=_blank>Visit Plugin Website</a>.</font><br><br>
    Enter Recurring Price: <br><input type="text" name="recurprice" value="<?php echo esc_html($myrowedit->recurprice); ?>"><br><br>
    Enter Number Of Days After Which The Charge Should Recur (Between 1-90): <br><input type="text" name="recurperiod" value="<?php echo esc_html($myrowedit->recurperiod); ?>"><br><br>
    Enter Number Of Times Charge Should Recur: <br><input type="text" name="recurnumber" value="<?php echo esc_html($myrowedit->recurnumber); ?>"><br><br>
</div>

<input type="submit" value="Edit PMPayLink">
</form>
<?php
wp_enqueue_script('jquery');
?>
<script>
    jQuery(document).ready(function($){
	var paylinktypeold = $('#paylinktypeold').val();
        if(paylinktypeold === "") {
        $('#buynow').hide();
        $('#trialsubs').hide();
        $('#subs').hide();
	} else if(paylinktypeold == "buynow") {
        $('#trialsubs').hide();
        $('#subs').hide();
	} else if(paylinktypeold == "trialsubs") {
        $('#buynow').hide();
        $('#subs').hide();
	} else if(paylinktypeold == "subs") {
        $('#buynow').hide();
        $('#trialsubs').hide();
        }
        
$('#paylinktype').on('change', function() {
        var value = $(this).val();
        if(value == "buynow") {

        $('#buynow').show();
        $('#trialsubs').hide();
        $('#subs').hide();

        } else if(value == "trialsubs") {

        $('#trialsubs').show();
        $('#buynow').hide();
        $('#subs').hide();

        } else if(value == "subs") {

        $('#subs').show();
        $('#buynow').hide();
        $('#trialsubs').hide();

        }
        
        else {
        
        $('#buynow').hide();
        $('#trialsubs').hide();
        $('#subs').hide();

        }
        

    });
}); 
</script>
<?php
}//end edit pmpaylink
else
{
?>
<h1 align="center">List PM Pay Links</h1>
<br><br><strong><a href="<?php echo esc_url($pmcreateurl); ?>"><button type="button">Create PM Pay Links</button></a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <strong>List All PM Pay Links</strong> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href="<?php echo esc_url($pmhelpurl); ?>"><button type="button">Help</button></a></strong>
<br><br>
<?php
if($_GET['pmcm']=="del")
{
?>
<font color="red" size=4>
<?php echo "Successfully Deleted."; ?><br><br>
</font>
<?php
}
?>	
<?php
foreach($wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."pmpaylinksdata" ) as $key => $myrowlist)
{
$pmediturl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_listlink_sl&dnum=".$myrowlist->datanumber;
$pmdelurl = $pmlisturl."&pmcm=del&dnumd=".$myrowlist->datanumber;
?>
<div style="border:1px solid black;">
<font size=3>
<strong>Link ID:</strong> <?php echo esc_html($myrowlist->linkid); ?> &nbsp&nbsp&nbsp&nbsp&nbsp
<strong>Link Short Tag:</strong> <?php echo esc_html($myrowlist->linkshorttag); ?>&nbsp&nbsp&nbsp&nbsp&nbsp
<strong>Link Anchor Text:</strong> <?php echo esc_html($myrowlist->linktext); ?> &nbsp&nbsp&nbsp&nbsp&nbsp
<strong>Actions:</strong> <a href="<?php echo esc_url($pmediturl); ?>">EDIT</a> &nbsp&nbsp&nbsp&nbsp&nbsp <a href="<?php echo esc_url($pmdelurl); ?>">DELETE</a>
</font>
</div>
<?php
}//end foreach
}// end else
?>

<br><br><br><strong>Do you want to automatically fulfill orders (send an automatic email or send IPN to some web service after PayPal confirms the payment)?</strong> 
<br>If so, click on the banner below to purchase the PMPayLinks Pro plugin and set up auto fulfillment on every PMPayLink you create.
<br><br>Users love our PRO version for the ability to set IPN to notify any other web service of PayPal payment & our all women friendly support team even help set it up if required.
<br>Also pro version gives you ability to select your choice of currency for PayPal payment.
<br><br>
<a href="https://www.pmpaylinks.site" target=_blank><img src="<?php echo(plugin_dir_url( __FILE__ )); ?>/pmpaylinksprobanner.png" style="height:auto;max-width:100%;border:none;display:block;" alt="Upgrade To Pro Today"></a>
<br><br>
For any help or customization in the plugin, feel free to email us at support@pmpaylinks.site
<br><br>
</div>
<p align="center"><a href="https://www.pmpaylinks.site" target=_blank><img src="<?php echo(plugin_dir_url( __FILE__ )); ?>/logo.png"></a></p>
<?php
}


function pmpaylinks_helppage() {
global $wpdb;
$blogurl = get_bloginfo ( 'wpurl' );
$pmmainurl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_main_sl";
$pmcreateurl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_createlink_sl";
$pmlisturl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_listlink_sl";
$pmhelpurl = $blogurl."/wp-admin/admin.php?page=pmpaylinks_help_sl";
?>
<p align="center"><a href="https://www.pmpaylinks.site" target=_blank><img src="<?php echo(plugin_dir_url( __FILE__ )); ?>/pmpaylinkstopbanner.png"></a></p>
<div align="center" style="background-color: #ffdbf6;width: auto;border: 5px solid black;padding: 50px;margin: 20px;">
<h1 align="center">PM Pay Links Help</h1>
Visit <a href="https://www.pmpaylinks.site" target=_blank>plugin website</a> to read all about plugin, see demo & find help for customization.
<br><br><a href="<?php echo esc_url($pmcreateurl); ?>"><button type="button">Create PM Pay Links</button></a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href="<?php echo esc_url($pmlisturl); ?>"><button type="button">List All PM Pay Links</button></a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href="<?php echo esc_url($pmhelpurl); ?>"><button type="button">Help</button></a>
<br><br><strong><u>How To Use The Plugin</u></strong>
<br><br>
Click on above buttons to create PMPayLink. <br>Once created with your choice of short code/tag, you can then use the same short code/tag anywhere on your site pages. <br>It will automatically generate a payment link there (for which you can also set your choice of link anchor text).
<br><br><strong><u>Why Upgrade To Pro?</u></strong>
<br><br>
By upgrading to PRO plugin, you will:<br><br>
-Be able to select from your choice of currency for pay link<br><br>
-Be able to automatically fulfill orders after payment confirmation from PayPal<br>(even if buyer closes the PayPal window after payment without coming back to your thanks URL)<br><br>
-Get FREE IPN set up assistance if required<br><br>
-Support & appreciate work of an all women team 
<br><br><strong><u>Need Any Customization?</u></strong>
<br><br>
The plugin can be customized as per your requirements.<br><br>
Customizations includes but not limited to: <br><br>-Tracking of pay link clicks<br><br>-Recording sales & customer data<br><br>-Adding custom buy now buttons & images for paylinks<br><br>-Sending customized emails (reminder or notifications)<br><br>-Adding tracking pixels to track conversions<br><br>-Adding an auto responder<br><br>-And much more....
<br><br>We can even create a custom plugin for you. Simply email our friendly all support team at support@pmpaylinks.site to discuss further.

<br><br><br><strong>Do you want to automatically fulfill orders (send an automatic email or send IPN to some web service after PayPal confirms the payment)?</strong> 
<br>If so, click on the banner below to purchase the PMPayLinks Pro plugin and set up auto fulfillment on every PMPayLink you create.
<br><br>Users love our PRO version for the ability to set IPN to notify any other web service of PayPal payment & our all women friendly support team even help set it up if required.
<br>Also pro version gives you ability to select your choice of currency for PayPal payment.
<br><br>
<a href="https://www.pmpaylinks.site" target=_blank><img src="<?php echo(plugin_dir_url( __FILE__ )); ?>/pmpaylinksprobanner.png" style="height:auto;max-width:100%;border:none;display:block;" alt="Upgrade To Pro Today"></a>
<br><br>
For any help or customization in the plugin, feel free to email us at support@pmpaylinks.site
<br><br>
</div>
<p align="center"><a href="https://www.pmpaylinks.site" target=_blank><img src="<?php echo(plugin_dir_url( __FILE__ )); ?>/logo.png"></a></p>
<?php
}


function pmpaylinks_in_content($content) {
global $wpdb;

foreach($wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."pmpaylinksdata" ) as $key => $myrowlink)
{

$custompaypal = $myrowlink->datanumber;
$pmhtml = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="pmpaylinksform">';
if($myrowlink->paylinktype=="buynow") {
$pmhtml .= '<input type="hidden" name="cmd" value="_xclick">';
} else {
$pmhtml .= '<input type="hidden" name="cmd" value="_xclick-subscriptions">';
}
$pmhtml .= '<input type="hidden" name="business" value="'.$myrowlink->paypalemail.'">
<input type="hidden" name="currency_code" value="'.$myrowlink->currency.'">
<input type="hidden" name="item_name" value="'.$myrowlink->productname.'">';
if($myrowlink->paylinktype=="trialsubs") {
$pmhtml .= '<input type="hidden" name="a1" value="'.$myrowlink->trialprice.'">
<input type="hidden" name="p1" value="'.$myrowlink->trialperiod.'">
<input type="hidden" name="t1" value="D">'; 
}
if($myrowlink->paylinktype=="trialsubs") { 
$pmhtml .= '<input type="hidden" name="a3" value="'.$myrowlink->trialrecurprice.'">
<input type="hidden" name="p3" value="'.$myrowlink->trialrecurperiod.'">
<input type="hidden" name="t3" value="D">';
if($myrowlink->trialrecurnumber!="1") {
$pmhtml .= '<input type="hidden" name="src" value="1">';
}
if($myrowlink->trialrecurnumber!="1" && $myrowlink->trialrecurnumber!="0") { 
$pmhtml .= '<input type="hidden" name="srt" value="'.$myrowlink->trialrecurnumber.'">';
} 
}
elseif($myrowlink->paylinktype=="subs") { 
$pmhtml .= '<input type="hidden" name="a3" value="'.$myrowlink->recurprice.'">
<input type="hidden" name="p3" value="'.$myrowlink->recurperiod.'">
<input type="hidden" name="t3" value="D">';
if($myrowlink->recurnumber!="1") {
$pmhtml .= '<input type="hidden" name="src" value="1">';
}
if($myrowlink->recurnumber!="1" && $myrowlink->recurnumber!="0") { 
$pmhtml .= '<input type="hidden" name="srt" value="'.$myrowlink->recurnumber.'">';
} 
}
else
{
$pmhtml .= '<input type="hidden" name="amount" value="'.$myrowlink->buynowprice.'">';
}
$pmhtml .= '<input type="hidden" name="no_note" value="1">
<input type="hidden" name="no_shipping" value="1"> 
<input type="hidden" name="return" value="'.$myrowlink->thanksurl.'"> 
<input type="hidden" name="rm" value="2">
<input type="hidden" name="cancel_return" value="'.$myrowlink->cancelurl.'"> 
<input type="hidden" name="custom" value="'.$custompaypal.'">
</form>';

$linkurl = plugin_dir_url( __FILE__ )."/pay.php?dnum=".$myrowlink->datanumber;
$repc = '<a href="#" onclick="document.getElementById(\'pmpaylinksform\').submit(); return false;">'.$myrowlink->linktext.'</a>';
$pmhtml .= $repc;
$content = str_replace($myrowlink->linkshorttag,$pmhtml,$content);
}

return($content);

}

add_filter('the_content', 'pmpaylinks_in_content');


function pmpaylinks_create_set_tables()
{
global $wpdb;

$sql1  = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."pmpaylinksdata (";
	$sql1 .= "   `datanumber` int NOT NULL AUTO_INCREMENT,";
	$sql1 .= "   `linkid` varchar(50),";
	$sql1 .= "   `linkshorttag` varchar(50),";
	$sql1 .= "   `linktext` varchar(100),";
	$sql1 .= "   `currency` varchar(10),";
	$sql1 .= "   `paypalemail` varchar(100),";
	$sql1 .= "   `productname` varchar(100),";
	$sql1 .= "   `thanksurl` varchar(100),";
	$sql1 .= "   `cancelurl` varchar(100),";
	$sql1 .= "   `paylinktype` varchar(100),";
	$sql1 .= "   `buynowprice` varchar(10),";
	$sql1 .= "   `trialprice` varchar(10),";
	$sql1 .= "   `trialperiod` varchar(10),";
	$sql1 .= "   `trialrecurprice` varchar(10),";
	$sql1 .= "   `trialrecurperiod` varchar(10),";
	$sql1 .= "   `trialrecurnumber` varchar(10),";
	$sql1 .= "   `recurprice` varchar(100),";
	$sql1 .= "   `recurperiod` varchar(100),";
	$sql1 .= "   `recurnumber` varchar(100),";
	$sql1 .= "   PRIMARY KEY  (`datanumber`)";
	$sql1 .= " ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";


$wpdb->query($sql1);

}

register_activation_hook( __FILE__, 'pmpaylinks_create_set_tables' );

function pmpaylinks_del_tables()
{
global $wpdb;

$sql2 = "DROP TABLE ".$wpdb->prefix."pmpaylinksdata";

$wpdb->query($sql2);

}

register_deactivation_hook( __FILE__, 'pmpaylinks_del_tables' );


?>
