<?php 
$this->start('head'); ?>
<link rel="stylesheet" type="text/css" href="<?=URLROOT?>/app/views/assets/css/glass.css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
    <section class="glass">
        <div class="hero-wrapper">
            <img src="<?=URLROOT?>/app/views/assets/img/pwb1.png" alt="">
        </div>
        <div class="form-wrapper">
            <h1>Set Admin</h1>
            <form action="" method="post">
                <?=csrfInput()?>
                <div class="input-control">
                    <?=getError('admin',$this->errors)?>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="<?=$this->user->email?>">
                    <?=getError('email',$this->errors)?>
                </div>
                <div class="input-control">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" value="<?=$this->user->username?>">
                    <?=getError('username',$this->errors)?>
                </div>
                <div class="input-control">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" value="<?=$this->user->password?>">
                    <?=getError('password',$this->errors)?>
                </div>
                <div class="input-control">
                    <label for="confirm">Confim Passowrd</label>
                    <input id="confirm" type="password" name="confirm" value="<?=$this->user->confirm?>">
                    <?=getError('confirm',$this->errors)?>
                </div>
                <div class="input-control">
                    <input id="register" type="submit" name="submit" value="Create Account">
                </div>
            </form>
        </div>
    </section>
<?php $this->end(); ?>