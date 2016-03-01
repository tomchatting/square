<div class="container">
	<h1><?php if(isset($post)) { echo 'Edit'; $command = 'edit'; } else { echo 'New'; $command = 'new'; } ?> Post</h1>
	<div>
		<div class='message'>
			<strong>HTML Guide</strong>
			<p>Even idiots like me can write HTML!</p>
			<p><code>&lt;h1&gt;Header Level 1&lt;/h1&gt;</code></p>
			<p><code>&lt;strong&gt;<strong>Emphasis</strong>&lt;/strong&gt;</code></p>
			<p><code>A &lt;a href="#"&gt;url&lt;/a&gt;</code></p>
			<p><code>&lt;img src="/img/img.png" alt="An Image"&gt;</code></p>
		</div>
		<form action="" method="post">
				<?php if($command == 'edit'){ echo '<input type="text" name="id" value="'.$post['id'].'">'; } ?>
				<p><label>Title:</label><br><input type="text" name="title" class="title" tabindex=1 <?php echo 'value="'. htmlspecialchars($post['title']) .'"'; ?>></p>
				<p><label>Date <code>(YYYY-MM-DD HH:MM)</code>:</label> <input type="text" name="date" tabindex=2 value="<?php if(isset($post['date'])){ echo $post['date']; } else { echo date('Y-m-d G:i:s'); } ?>" /></p>
				<p><label>Type:</label> <select name="type" tabindex=3><option value="article">Article</option><option value="page" <?php if($post['type']=='page'){ echo 'selected'; } ?>>Page</option></select></p>
				<p><label>Content:</label><br><textarea name="content" rows=4 cols=50 tabindex=4><?php echo htmlspecialchars($post['content']); ?></textarea></p>
				<!-- Generate category boxes -->
				<?php
					$categories = Database::return_array('SELECT * from `square_categories`', true);
					foreach ($categories as $cat) {
						if($post['category1'] == $cat['id']){$selected = 'selected';}
						$select1 .= '<option value="'.$cat['id'].'"'.$selected.'>'.$cat['name'].'</option>';
						$selected = '';
						if($post['category2'] == $cat['id']){$selected = 'selected';}
						$select2 .= '<option value="'.$cat['id'].'"'.$selected.'>'.$cat['name'].'</option>';
						$selected = '';
					}
				?>
				<p><label>Category 1:</label> <select name="category1" tabindex=5><option value="0"></option><?php echo $select1; ?></select>
        <label>Category 2:</label> <select name="category2" tabindex=6><option value="0"></option><?php echo $select2; ?></select></p>
				<p><label>URL <code>(if left blank will auto generate)</code>:</label> <input type="text" name="url" tabindex=7 value="<?php echo $post['url']; ?>" /></p>
				<p><label>Status:</label> <select name="status" tabindex=8><option value="draft">Draft</option><option value="publish" <?php if($post['status']=='publish'){ echo 'selected'; } ?>>Publish</option></select></p>
				<button name="<?php echo $command; ?>" type="submit" value="com" class="commit" tabindex=9>Commit</button>
		</form>
	</div>
	<footer><small>sc v <?php echo Square::$version; ?></small></footer>
</div>
