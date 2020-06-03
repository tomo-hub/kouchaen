<?php foreach(get_errors() as $error){ ?>
  <p class="err_msg"><?php print h($error); ?></p>
<?php } ?>
<?php foreach(get_messages() as $message){ ?>
  <p class="result_msg"><span><?php print h($message); ?></span></p>
<?php } ?>