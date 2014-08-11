<?php

$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
	'Register',
);
?>

<h1>Register</h1>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'afterValidate' => 'js:function(form, data, hasError){
			var username = $("#UserAccount_username").val();
			var email    = $("#UserAccount_email").val();
			var password = $("#UserAccount_password").val();
			if(!hasError)
			{
				$.ajax({
					"type" : "POST",
					"context" : this,
					"cache" : "false",
					"dataType":"json",
					"url"   : "index.php?r=site/ajaxRegister",
					"data"  : {username:username, email:email, password:password},
					"beforeSend" : function(){
						$("#loader").show();
						$("#subBtn").attr("disabled", true);
					},
					"success" : function(data){
						window.location.href = data.redirect;
					}
				
				});
			}
		}'
	),
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
     <div class="row buttons">
		<?php echo CHtml::submitButton('Submit', array('id' => 'subBtn')); ?>
		<span id="loader" style="display:none;"> <?php echo CHtml::image('images/ajax-loader.gif'); ?></span>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

