<?php use Core\Navigation;?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->siteTitle(); ?></title>
  <?= $this->content('head'); ?>

  </head>
  <body>
      <?php Navigation::getList('users_nav');?>
      <?= $this->content('body'); ?>
  </body>
</html>
