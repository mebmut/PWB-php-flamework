<?php 
$this->start('head'); ?>
<link rel="stylesheet" type="text/css" href="<?=URLROOT?>/app/views/assets/css/glass.css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
    <section class="glass fluid">
        <div class="hero-wrapper">
            <img src="<?=URLROOT?>/app/views/assets/img/pwb1.png" alt="">
        </div>
        <div class="form-wrapper">
            <h1>Genarate Migration </h1>
            <form action="" method="post">
                <?=csrfInput()?>
                <div class="input-control">
                    <label for="table">Table Name</label>
                    <input id="table" type="text" name="table" value="<?=$this->migration->table?>">
                    <?=getError('table',$this->errors)?>
                </div>
                <input type="hidden" name="gen" value="gen">
                <div class="input-control">
                    <input id="submit" type="submit" value="Genarate Migration">
                </div>
            </form>
            <h1>Run migrations</h1>
            <form action="" method="post">
                <div class="input-control">
                    <input type="submit" name="run" value="Run Migrations">
                </div>
            </form>
        </div>
    </section>
<?php $this->end(); ?>