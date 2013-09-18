<!-- JQuery -->
<script src="../jquery/jquery-1.6.2.min.js"></script>  

<!-- General JS/Styles -->
<script src="../js/general.js"></script>  
<link href="../css/general.css" rel="stylesheet" type="text/css" />

<!-- Menu -->
<script src="../js/preload_menu.js"></script>  

<!-- Validate -->
<script type="text/javascript" language="javascript" src="../jquery-plugins/validation/jquery.validate.min.js"></script>

<!-- Slidebox -->
<script type="text/javascript" language="javascript" src="../jquery-plugins/slidebox/jquery.easing.1.3.js"></script>
<link href="../css/slidebox.css" rel="stylesheet" type="text/css" />

<!-- Colorbox -->
<script src="../jquery-plugins/colorbox/jquery.colorbox-min.js"></script>
<link rel="stylesheet" href="../jquery-plugins/colorbox/colorbox.css">

<!-- Search function -->
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$('#query').keypress(function(e) {
		if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
			var searchlocation = 'results.php?query=' + encodeURI($(this).val());
			window.location = searchlocation;
		}
	});
});
</script>