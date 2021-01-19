<?php 
$this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>
    <section class="glass fluid">
        <div class="hero-wrapper">
            <img src="<?=URLROOT?>/app/views/assets/img/pwb1.png" alt="">
        </div>
        <div class="form-wrapper">
            <h1>Genarate model </h1>
            <form action="" method="post">
                <?=csrfInput()?>
                <div class="input-control">
                    <label for="model">Model Name</label>
                    <input id="model" type="text" name="model" value="<?=$this->model->model?>">
                    <?=getError('model',$this->errors)?>
                </div>
                <div class="input-control">
                    <label for="table">Table Name</label>
                    <input id="table" type="text" name="table" value="<?=$this->model->table?>">
                    <?=getError('table',$this->errors)?>
                </div>
                <fieldset>
                   <div class="fieldset-control">
                        <label for="construct">construct</label>
                        <input type="checkbox" name="construct" id="construct">
                   </div>

                   <div class="fieldset-control">
                        <label for="onConstruct">onConstruct</label>
                        <input type="checkbox" name="onConstruct" id="onConstruct">
                   </div>

                   <div class="fieldset-control">
                        <label for="validator">Validator</label>
                        <input type="checkbox" name="validator" id="validator">
                   </div>
                   <div class="fieldset-control">
                        <label for="beforeSave">BeforeSave</label>
                        <input type="checkbox" name="beforeSave" id="beforeSave">
                   </div>
                   <div class="fieldset-control">
                        <label for="afterSave">AfterSave</label>
                        <input type="checkbox" name="afterSave" id="afterSave">
                   </div>
                </fieldset>
                <div class="input-control">
                    <input id="submit" type="submit" value="Genarate model">
                </div>
            </form>
        </div>
    </section>
<?php $this->end(); ?>