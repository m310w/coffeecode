<?php
require("../lib/page.php");
Page::header("Bienvenid@");
?>

<div class="row">
	<h4 class='center-align'>Hoy es <?php print(date('d/m/Y')); ?></h4>
</div>

<?php
Page::footer();
?>