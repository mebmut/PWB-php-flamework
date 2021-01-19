<?php use Core\{Session,Navigation}; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->siteTitle(); ?></title>
    <link rel="stylesheet" type="text/css" href="<?=URLROOT?>/app/views/assets/css/glass.css">
    <link rel="stylesheet" href="<?=URLROOT?>app/views/assets/css/app.css">
  <?= $this->content('head'); ?>

  </head>
  <body>
    <div class="wrapper">
      <?php if($massage = Session::getMassage()): ;?>
        <script>
           alert('<?=$massage?>');
        </script>
      <?php endif; ?>
      <nav class="nav-wrapper">
         <?php Navigation::getList('settings_nav');?>
      </nav>
      <?= $this->content('body'); ?>
    </div>
    <div class="toutch-top"></div>
    <div class="toutch-btm"></div>
  </body>
</html>
