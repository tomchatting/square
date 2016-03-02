<div class="container">
	<h1>Settings</h1>

  <?php
  function formatOffset($offset) {
        $hours = $offset / 3600;
        $remainder = $offset % 3600;
        $sign = $hours > 0 ? '+' : '-';
        $hour = (int) abs($hours);
        $minutes = (int) abs($remainder / 60);

        if ($hour == 0 AND $minutes == 0) {
            $sign = ' ';
        }
        return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) .':'. str_pad($minutes,2, '0');

}

$utc = new DateTimeZone('UTC');
$dt = new DateTime('now', $utc);
?>

    <form method="post" action="./?cmd=settings" class="settings">

      <table>
        <tr><td>Site title: </td><td><input type="text" name="site_name" class="settings" value="<?php echo $setting['site_name']; ?>"></td></tr>
        <tr><td>Tagline: </td><td><input type="text" name="tagline" class="settings" value="<?php echo $setting['tagline']; ?>">
        <code>A headline for your blog</code></td></tr>
        <tr><td>Username:</td><td><input type="text" name="username" class="settings" value="<?php echo $setting['username']; ?>">
        <code>How you log in, part one</code></td></tr>
        <tr><td>Password:</td><td><input type="text" name="password" class="settings"> <input type="text" name="password_validation" class="settings">
        <br><code>How you log in, part two. Enter twice for validation.</code></td></tr>
        <tr><td>Time offset:</td><td>
          <?php

          echo '<select name="userTimeZone">';
foreach(DateTimeZone::listIdentifiers() as $tz) {
    $current_tz = new DateTimeZone($tz);
    $offset =  $current_tz->getOffset($dt);
    $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
    $abbr = $transition[0]['abbr'];

    echo '<option value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. formatOffset($offset). ']</option>';
}
echo '</select>';

          ?>
        </td></tr>
        <tr><td>Template directory:</td><td><input type="text" name="username" class="settings" value="<?php echo $setting['template']; ?>">
        <code>Template directory</code></td></tr>
      </table>

      <p><button name="submit" type="submit" value="action">Save</button></p>

    </form>
</div>
