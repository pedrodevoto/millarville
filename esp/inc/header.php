<div id="header">
    <div style="padding:20px;">
        <div style="float:left; padding-top:30px;"><a href="../index.php"><img src="../img/logo_small.png" width="180" height="41" border="0" /></a></div>
        <div style="float:right;" class="f_yellow f_12">
            <table cellpadding="4" cellspacing="0">
                <tr>
                    <td style="padding-right:10px;">
						<?php if (isset($_SESSION['User_MM_Username'])) { ?>
                            <a href="logout.php" class="f_yellow f12">SALIR</a> | <a href="account.php" class="f_yellow f12">MI CUENTA</a> | 
                        <? } else { ?>
                            <a href="login.php" class="f_yellow f12">INGRESAR</a> | <a href="register.php" class="f_yellow f12">REGISTRARSE</a> |                     
                        <?php } ?>
						<a href="bag.php" class="f_yellow f12">MI BOLSA</a> | SEGUINOS</td>
                    <td><a href="http://www.twitter.com/" target="_blank"><img src="../img/twitter.png" width="23" height="24" border="0" /></a></td>
                    <td><a href="http://www.facebook.com/" target="_blank"><img src="../img/facebook.png" width="23" height="24" border="0" /></a></td>
                    <td style="padding-left:10px;"><a href="http://www.alegriapolo.com/" target="_blank"><img src="../img/alegria.png" width="52" height="49" border="0" /></a></td>
                </tr>
            </table>
        </div>
        <br clear="all" />
    </div>
</div>
