<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->siteTitle(); ?></title>
    <link rel="stylesheet" href="<?=URLROOT?>app/views/assets/css/app.css">
  <?= $this->content('head'); ?>

  </head>
  <body>
      <?= $this->content('body'); ?>
  </body>
</html>
