<div class=container>
	<h1><?php if(isset($post)) { echo 'Edit'; $command = 'edit'; } else { echo 'New'; $command = 'new'; } ?> Post</h1>
	<div>
		<form action="" method=post>
				<?php if($command == 'edit'){ echo '<input name=id type=hidden value="'.$post['id'].'">'; } ?>
				<p><label>Title:<br><input type=text name=title id=title class=title <?php echo 'value="'. htmlspecialchars($post['title']) .'"'; ?>></label></p>
				<p><label>Date <code>(YYYY-MM-DD HH:MM)</code>: <input type="text" name="date" value="<?php if(isset($post['date'])){ echo $post['date']; } else { echo date('Y-m-d G:i:s'); } ?>" /></label></p>
				<p><label>Type: <select name=type><option value="article">Article</option><option value="page" <?php if($post['type']=='page'){ echo 'selected'; } ?>>Page</option></select></label></p>
				<p><label>Content <code>(GitHub flavoured Parsedown!)</code>:<br><textarea name="content" rows=4 cols=50><?php echo htmlspecialchars($post['content']); ?></textarea></label></p>
				<!-- Generate category boxes -->
				<?php
					$categories = Database::return_array('SELECT * from `square_categories`', true);
					if($categories) {
					foreach ($categories as $cat) {
						if($post['category1'] == $cat['id']){$selected = 'selected';}
						$select1 .= '<option value="'.$cat['id'].'"'.$selected.'>'.$cat['name'].'</option>';
						$selected = '';
						if($post['category2'] == $cat['id']){$selected = 'selected';}
						$select2 .= '<option value="'.$cat['id'].'"'.$selected.'>'.$cat['name'].'</option>';
						$selected = '';
					}
					}
				?>
				<p><label>Category 1: <select name=category1><option value="0"></option><?php echo $select1; ?></select></label>
        <label>Category 2: <select name=category2><option value="0"></option><?php echo $select2; ?></select></label></p>
				<p><label>URL: <input type=text name=url id=url value="<?php echo $post['url']; ?>" /></label></p>
				<p><label>Status: <select name=status><option value="draft">Draft</option><option value="publish" <?php if($post['status']=='publish'){ echo 'selected'; } ?>>Publish</option></select></label></p>
				<button name="<?php echo $command; ?>" type="submit" value="com" class="commit">Commit</button>
		</form>
	</div>
	<footer><small>sc v <?php echo Square::$version; ?></small></footer>
</div>
<script type='text/javascript'>//<![CDATA[
window.onload=function(){
var inputLtc = document.getElementById('title'),
    inputBtc = document.getElementById('url');

function convertToSlug(Text) {
  return Text
    .toLowerCase()
    .replace(/[^\w ]+/g,'')
    .replace(/ +/g,'-')
    ;
}

inputLtc.onkeyup = function() {
	inputBtc.value = convertToSlug(inputLtc.value).toLowerCase();
};
}//]]>

</script>
