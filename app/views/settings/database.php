<?php 
$this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
    <section class="glass">
        <div class="hero-wrapper">
            <img src="<?=URLROOT?>/app/views/assets/img/pwb1.png" alt="">
        </div>
        <div class="form-wrapper">
            <h1>Add Database</h1>
            <form action="" method="post">
                <?=csrfInput()?>
                <div class="input-control">
                    <label for="dbname">Database Name</label>
                    <input id="dbname" type="text" name="dbname" value="<?=$this->db->dbname?>">
                    <?=getError('dbname',$this->errors)?>
                </div>
                <div class="input-control">
                    <label for="dbuser">Database user</label>
                    <input id="dbuser" type="text" name="dbuser" value="<?=$this->db->dbuser?>">
                    <?=getError('dbuser',$this->errors)?>
                </div>
                <div class="input-control">
                    <label for="dbpass">Database Passowrd</label>
                    <input id="dbpass" type="password" name="dbpass" value="<?=$this->db->dbpass?>">
                    <?=getError('dbpass',$this->errors)?>
                </div>
                <div class="input-control">
                    <label for="dbhost">Database Host</label>
                    <input id="dbhost" type="text" name="dbhost" value="<?=$this->db->dbhost?>">
                    <?=getError('dbhost',$this->errors)?>
                </div>
                <div class="input-control">
                    <input id="submit" type="submit" name="submit" value="Add Database">
                </div>
            </form>
        </div>
    </section>
<?php $this->end(); ?>