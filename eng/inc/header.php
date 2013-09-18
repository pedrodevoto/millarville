<div id="header">
    <div style="padding:20px; width:797px;">
        <div style="float:left; padding-top:30px;"><a href="../index.php"><img src="../img/logo-rojo_small.png" width="180" height="47" border="0" /></a></div>
        <div style="float:right;" class="f_yellow f_12">
            <table cellpadding="4" cellspacing="0">
                <tr>
                    <td style="padding-right:10px;">
						<?php if (isset($_SESSION['User_MM_Username'])) { ?>
                            <a href="account.php" class="f_yellow f12">YOUR ACCOUNT</a> | <a href="logout.php" class="f_yellow f12">LOGOUT</a> | 
                        <? } else { ?>
                            <a href="register.php" class="f_yellow f12">SIGN UP</a> | <a href="login.php" class="f_yellow f12">LOGIN</a> |                     
                        <?php } ?>
						<a href="bag.php" class="f_yellow f12">SHOPPING BAG</a> | </td>
                    <td><a href="http://www.twitter.com/" target="_blank"><img src="../img/twitter.png" border="0" /></a></td>
                    <td><a href="http://www.facebook.com/" target="_blank"><img src="../img/facebook.png" border="0" /></a></td>
                    <td style="padding-left:10px;"><a href="http://www.alegriapolo.com/" target="_blank"><img src="../img/alegria.png" border="0" /></a></td>
                </tr>
            </table>
        </div>
        <br clear="all" />
    </div>
</div>
