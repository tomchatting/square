<div class="wrapper">
	<h1 class="page">New Post</h1>
	<div class="page">
		<div class="left">
			<strong>HTML Guide</strong>
			<p>Even idiots like me can write HTML!</p>
			<p><code>&lt;h1&gt;Header Level 1&lt;/h1&gt;</code></p>
			<p><code>&lt;strong&gt;<strong>Emphasis</strong>&lt;/strong&gt;</code></p>
			<p><code>A &lt;a href="#"&gt;url&lt;/a&gt;</code></p>
			<p><code>&lt;img src="/img/img.png" alt="An Image"&gt;</code></p>
		</div>
		<form action="" method="post" class="full-post">
				<p><label>Title:</label><br><input type="text" name="title" class="title" tabindex=1 /></p>
				<p><label>Content:</label><br><textarea name="content" rows=4 cols=50 tabindex=2></textarea></p>
				<p><label>Category 1:</label> <select name="status" id="status" class="publish" tabindex=6><option value="publish"></option><option value="publish">A marvellous Category</option><option value="draft">Another one</option></select></p>
        <p><label>Category 2:</label> <select name="status" id="status" class="publish" tabindex=6><option value="publish"></option><option value="publish">A marvellous Category</option><option value="draft">Another one</option></select></p>
				<p><label>Date <code>(YYYY-MM-DD HH:MM)</code>:</label> <input type="text" name="date" tabindex=4 value="2016-03-01 10:36" /></p>
				<p><label>Status:</label> <select name="status" id="status" class="publish" tabindex=6><option value="publish">Publish</option><option value="draft">Draft</option></select></p>
				<button name="submit" type="submit" value="com" class="commit" tabindex=7>Commit</button>
		</form>
	</div>
	<p class="footer">sc v <?php echo Square::$version.filemtime('index.php'); ?></p>
</div>
