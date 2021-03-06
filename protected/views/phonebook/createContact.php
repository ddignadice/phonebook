<?php

$this->pageTitle=Yii::app()->name . ' - Create Contact';
$this->breadcrumbs=array(
	'Create Contact',
);
?>

<h1>Create Contact</h1>

<div id="error_div"><div id="error"></div></div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'create_contact',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'afterValidate' => 'js:function(form, data, hasError){
			if(!hasError)
			{
				var firstName = $("#Dossier_first_name").val();
				var middleName = $("#Dossier_middle_name").val();
				var lastName  = $("#Dossier_last_name").val();
				var suffix    = $("#Dossier_suffix").val();
				var title     = $("#Dossier_title").val();
				var birthday  = $("#Dossier_birthday").val();
				var home_number = $("#Dossier_home_number").val();
				var mobile_number = $("#Dossier_mobile_number").val();
				var email = $("#Dossier_email").val();
				var street = $("#Dossier_street").val();
				var city = $("#Dossier_city").val();
				var postal_code = $("#Dossier_postal_code").val();
				var country     = $("#Dossier_country").val();
				
				if(firstName == "" && 
				   middleName == "" && 
				   lastName == "" && 
				   suffix == "" && 
				   title == "" && 
				   birthday == "" &&
				   home_number == "" &&
				   mobile_number == "" &&
				   email == "" &&
				   street == "" &&
				   city == "" &&
				   postal_code == ""
				   
				   )
				{
					alert("You must have atleast one field to create a contact");
				}
				else
				{
					$.ajax({
						"type"     : "POST",
						"url"  	   : "'.CHtml::normalizeUrl(array("phonebook/ajaxCreateContact")).'",
						"dataType" : "json",
						"data" 	: { firstName:firstName, 
									middleName:middleName, 
									lastName:lastName, 
									suffix:suffix, 
									title:title, 
									birthday:birthday, 
									home_number:home_number,
									mobile_number:mobile_number,
									email:email,
									street:street,
									city:city,
									postal_code:postal_code,
									country:country
									},
						
						"beforeSend" : function(){
							$("#loader").show();
							$("#subBtn").attr("disabled", true);
						},
						"success" : function(data){
							window.location.href = data.redirect;
						}
					});
				}
			 }
			
		
		}'
	),
)); ?>

 <fieldset>
	<legend>Personal Info</legend>
	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name'); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'middle_name'); ?>
		<?php echo $form->textField($model,'middle_name'); ?>
		<?php echo $form->error($model,'middle_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name'); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'suffix'); ?>
		<?php echo $form->textField($model,'suffix'); ?>
		<?php echo $form->error($model,'suffix'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'birthday'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array('name'=>"Dossier[birthday]",
				'options'=>array(
				'showAnim'=>'fold',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
			),
		));
	  ?>
	<?php echo $form->error($model,'birthday'); ?>
	</div>
</fieldset>
<fieldset>
	<legend>Contact Info</legend>
	<div class="row">
		<?php echo $form->labelEx($model,'home_number'); ?>
		<?php echo $form->textField($model,'home_number'); ?>
		<?php echo $form->error($model,'home_number'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'mobile_number'); ?>
		<?php echo $form->textField($model,'mobile_number'); ?>
		<?php echo $form->error($model,'mobile_number'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
</fieldset>
<fieldset>
	<legend>Address</legend>
	<div class="row">
		<?php echo $form->labelEx($model,'street'); ?>
		<?php echo $form->textField($model,'street'); ?>
		<?php echo $form->error($model,'street'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city'); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'postal_code'); ?>
		<?php echo $form->textField($model,'postal_code'); ?>
		<?php echo $form->error($model,'postal_code'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country'); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>
</fieldset>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Add', array('id' => 'subBtn')); ?>
		<span id="loader" style="display:none;"> <?php echo CHtml::image('images/ajax-loader.gif'); ?></span>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->