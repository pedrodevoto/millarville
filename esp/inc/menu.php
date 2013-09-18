<?php
	$url = $_SERVER['PHP_SELF'];
	$url_array = explode("/",$url);
	$page = end($url_array);
	$page_array = explode(".",$page);
	$section = $page_array[0];
?>
<div id="sections">
    <table cellpadding="0" cellspacing="0" height="24">
        <tr>
            <td valign="middle" style="padding-left:20px;"><a href="main.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Home','','img/sections/home-s.png',1)"><img src="img/sections/home<?php if ($section=="main") { echo "-s"; } ?>.png" alt="Home" name="Home" width="39" height="18" border="0" id="Home" /></a></td>
            <td valign="middle" style="padding-left:55px;"><a href="about.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('About','','img/sections/about-s.png',1)"><img src="img/sections/about<?php if ($section=="about") { echo "-s"; } ?>.png" alt="Nosotros" name="About" width="62" height="18" border="0" id="About" /></a></td>
            <td valign="middle" style="padding-left:55px;"><a href="products.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Products','','img/sections/products-s.png',1)"><img src="img/sections/products<?php if ($section=="products") { echo "-s"; } ?>.png" alt="Productos" name="Products" width="68" height="18" border="0" id="Products" /></a></td>
            <td valign="middle" style="padding-left:55px;"><a href="contact.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Contact','','img/sections/contact-s.png',1)"><img src="img/sections/contact<?php if ($section=="contact") { echo "-s"; } ?>.png" alt="Contact" name="Contacto" width="65" height="18" border="0" id="Contact" /></a></td>
            <td valign="middle" style="padding-left:55px;"><img src="img/sections/search.png" width="48" height="18" border="0" /></td>
            <td valign="middle" style="padding-left:55px;"><input type="text" name="query" id="query" maxlength="255" size="20" style="height:14px; border:0px; padding-left: 2px; padding-right: 2px" value="<?php if(isset($_GET['query'])) { echo $_GET['query']; } ?>" onclick="this.value='';" /></td>
        </tr>
    </table>
</div>