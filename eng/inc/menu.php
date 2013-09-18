<?php
	$url = $_SERVER['PHP_SELF'];
	$url_array = explode("/",$url);
	$page = end($url_array);
	$page_array = explode(".",$page);
	$section = $page_array[0];
?>
<script type="text/javascript">
function Drop(){
	if($("#Sub_prod").css('height') == '84px'){
		$("#Sub_prod").animate({
			height: "0px",
		},
		{
			easing: 'swing',
			duration: 1500,
			complete: function(){
				$("#Sub_prod").css('visibility','hidden');
			}
		});
	}else{
		$("#Sub_prod").css('visibility','visible');
		$("#Sub_prod").animate({
			height: "84px" 
		}, 1500 );
	}
}
</script>
<div id="sections">
    <table cellpadding="0" cellspacing="0" height="34" align="center" width="797">
        <tr>
            <td valign="middle"><a href="main.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Home','','img/sections/home-s.png',1)"><img src="img/sections/home<?php if ($section=="main") { echo "-s"; } ?>.png" alt="Home" name="Home" border="0" id="Home" /></a></td>
            <td valign="middle" style="padding-left:56px;"><a href="about.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('About','','img/sections/about-s.png',1)"><img src="img/sections/about<?php if ($section=="about") { echo "-s"; } ?>.png" alt="About Us" name="About" border="0" id="About" /></a></td>
            <td valign="middle" style="padding-left:56px;"><a style="cursor:pointer" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('Products','','img/sections/products-s.png',1);" onclick="Drop()"><img src="img/sections/products<?php if ($section=="products") { echo "-s"; } ?>.png" alt="Products" name="Products" border="0" id="Products" /></a></td>
            <td valign="middle" style="padding-left:56px;"><a href="contact.php" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('Contact','','img/sections/contact-s.png',1)"><img src="img/sections/contact<?php if ($section=="contact") { echo "-s"; } ?>.png" alt="Contact" name="Contact" border="0" id="Contact" /></a></td>
            <td valign="middle" style="padding-left:56px;"><a href="polo.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Polo','','img/sections/polo-s.png',1)"><img src="img/sections/polo<?php if ($section=="polo") { echo "-s"; } ?>.png" alt="Polo Team" name="Polo" border="0" id="Polo" /></a></td>
            <td valign="middle" style="padding-left:56px;"><img src="img/sections/coming.png" alt="Contact" name="Contact" border="0" id="Contact" /></td>
        </tr>
    </table>
    <div style="position:relative; top:-11px; left:-114px; height:0px; width:100px; background:url(../img/degmenu.jpg); visibility:hidden;" id="Sub_prod">
        <div style="border-bottom:1px dashed #bc3e45; padding:16px 8px 8px 8px; text-align:left; width:84px"><a href="products.php?categoria_id=1" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Player','','img/sections/player-s.png',1)"><img src="img/sections/player.png" alt="Players" name="Players" style="padding-left:1px;" border="0" id="Player" /></a></div>
        <div style="border-bottom:1px dashed #bc3e45; padding:8px 8px 8px 8px;  text-align:left; width:84px"><a href="products.php?categoria_id=2" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Horse','','img/sections/horse-s.png',1)"><img src="img/sections/horse.png" alt="Horse" name="Horse" style="padding-left:1px;" border="0" id="Horse" /></a></div>
        <div style="padding:8px 8px 8px 8px; text-align:left; width:84px"><a href="products.php?categoria_id=3" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Accesories','','img/sections/accesories-s.png',1)"><img src="img/sections/accesories.png" alt="Accesories" name="Accesories" style="padding-left:1px;" border="0" id="Accesories" /></a></div>
    </div>
</div>