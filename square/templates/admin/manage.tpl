<div class="container">
<h1>Manage Content</h1>

  <table id="manage-posts">
    <tr>
      <th class="id">ID</th>
      <th class="date">Date</th>
      <th class="title">Title</th>
      <th class="status">Status</th>
      <th class="type">Type</th>
      <th class="action">&#x25CF;</th>
    </tr>
    <?php
    foreach($result as $r) {
      $id = $r["id"];
    ?>
    <tr>
      <td class="id"><?php echo $id; ?></td>
      <td class="date"><?php echo $r['date'] ?></td>
      <td class="title"><a href="./?cmd=edit&id=<?php echo $id; ?>"><?php echo $r["title"]; if ($r['title'] == '') { echo "Untitled Post"; } ?></a></td>
      <td class="status"><?php echo $r["status"]; ?></td>
      <td class="type"><?php echo $r["type"]; ?></td>
      <td class="action"><a href=./?cmd=manage&delete=<?php echo $id; ?>></a></td>
    </tr>
    <?php
    }
    ?>
    <tr><th class="id">ID</th><th class="date">Date</th><th class="title">Title</th><th class="status">Status</th><th class="type">Type</th><th class="action">&#x25CF;</th></tr>
  </table>

<footer><small>sc v <?php echo Square::$version; ?></small></footer>
</div>
