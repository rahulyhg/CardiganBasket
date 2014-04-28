<form id="maven-registration-form" name="maven-registration-form" method="post" >
	<input type="hidden" id="maven-member-registering" name="maven-member-registering" value="1" />
        
	<?php if ($errors): ?>
	<ul>
		<?php foreach ($errors as $error): ?>
			<li>
				<span><?php echo $error ?></span><br />
			</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<?php echo $fields; ?>


</form>