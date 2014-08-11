<?php
$form = $this->beginWidget(
    'CActiveForm',
    array(
        'id' => 'upload-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )
);

	echo $form->labelEx($model, 'file_name');
	echo $form->fileField($model, 'file_name');
	echo $form->error($model, 'file_name');

	echo CHtml::submitButton('Submit');
	$this->endWidget();
?>