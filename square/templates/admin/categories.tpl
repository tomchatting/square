<div class="container">
<h1>Manage Categories</h1>
  <?php
  if($result) {
  ?>
  <table id="manage-posts">
    <tr>
      <th class="id">ID</th>
      <th class="name">Name</th>
      <th class="action">&#x25CF;</th>
    </tr>
    <?php
    foreach($result as $r) {
      $id = $r["id"];
    ?>
    <tr>
      <td class="id"><?php echo $id; ?></td>
      <td class="title"><?php echo $r["name"]; ?></td>
      <td class="action"><a href=./?cmd=categories&delete=<?php echo $id; ?>></a></td>
    </tr>
    <?php
    }
    ?>
  </table>
  <?php
  }
  ?>

  <form action=?cmd=categories method=post>

  <p><h2>New category</h2>
  <label>Name: </label><br><input type="text" name="name" class="name" tabindex=1 style="width:50%;"></p>
  <p><button name="submit" type="submit" value="action" style="width:50%">Create</button></p>

  </form>

<footer><small>sc v <?php echo Square::$version; ?></small></footer>
</div>
