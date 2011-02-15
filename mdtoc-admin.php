<?php
	if(isset($_POST['mdtoc_update']) && $_POST['mdtoc_update'] == 'update') {
		//Form data sent
		$selectedHeadings = $_POST['mdtoc_headings'];
		$serializedHeadings = serialize($selectedHeadings);
		update_option('mdtoc_headings', $serializedHeadings); 
?>
		<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
<?php 
	} 
	$headingsOption = get_option('mdtoc_headings');
	if(!is_array($headingsOption)){
		$selectedHeadings = unserialize($headingsOption);  
	} else {
		$selectedHeadings = $headingsOption;
	}
	if(!$selectedHeadings){ $selectedHeadings = array(); }
	$headings = array('1' => 'Heading 1', 
					  '2' => 'Heading 2', 
					  '3' => 'Heading 3', 
					  '4' => 'Heading 4', 
					  '5' => 'Heading 5', 
					  '6' => 'Heading 6');
?>

<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<?php    echo "<h2>" . __( 'Table of Contents Options', 'mdtoc_trdom' ) . "</h2>"; ?>

	<form name="mdtoc_form" id="mdtoc_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="mdtoc_update" value="update">
		<p><?php _e("Choose which headings should appear in the Table of Contents: " ); ?></p>
			<ul>
			<?php foreach($headings as $key => $value): ?>
				<li>
					<label for="<?php echo $key; ?>">
					<input type="checkbox" name="mdtoc_headings[]" 
						value="<?php echo $key; ?>" 
						id="<?php echo $key; ?>" 
						<?php if(in_array($key, $selectedHeadings)): ?>
							checked="checked"
						<?php endif; ?>
						/>
					<?php echo $value; ?></label>
					</li>
			<?php endforeach; ?>
			</ul>
		<p class="submit">
		<input type="submit" name="Submit" value="<?php _e('Update Options', 'mdtoc_trdom' ) ?>" />
		</p>
	</form>
	
	<h3>How to use the Table of Contents Plugin:</h3>
	<p>Simply place the tag "[toc]" (without the quotes) in the content of the post or page where you want the table of contents to appear.</p>
</div>
