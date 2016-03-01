<div class="container">
<h1>Manage Categories</h1>

  <table id="manage-posts">
    <tr>
      <th class="id">ID</th>
      <th class="name">Name</th>
      <th class="action">Action</th>
    </tr>
    <?php
    foreach($result as $r) {
      $id = $r["id"];
    ?>
    <tr>
      <td class="id"><?php echo $id; ?></td>
      <td class="title"><?php echo $r["name"]; ?></td>
      <td class="action"><a href=#>Rename</a> <a href=#>Delete</a></td>
    </tr>
    <?php
    }
    ?>
  </table>

  <form>

  <p><label>New category:</label><input type="text" name="name" class="name" tabindex=1>
  <button name="submit" type="submit" value="action">Apply</button></p>

  </form>

<footer><small>sc v <?php echo Square::$version.filemtime('index.php'); ?></small></footer>
</div>
