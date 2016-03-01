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
      <td class="action"><a href=./?cmd=categories&delete=<?php echo $id; ?>>Delete</a></td>
    </tr>
    <?php
    }
    ?>
  </table>

  <form action=?cmd=categories method=post>

  <p><label>New category:</label><input type="text" name="name" class="name" tabindex=1>
  <button name="submit" type="submit" value="action">Create</button></p>

  </form>

<footer><small>sc v <?php echo Square::$version; ?></small></footer>
</div>
