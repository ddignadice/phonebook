
 <div class='success'>
	<?php echo Yii::app()->user->getFlash('success'); ?>
</div>
 <?php
	echo CHtml::link('Create Contact',array('phonebook/createContact')).
     $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=> $model->search(),
		//'filter'      => $model,
        'columns' => array(
							array(
									'name' => 'Name',
									'value' => '$data->last_name.", ".$data->first_name'
							 ),
							 array(
									'name'  => 'Email',
									'value' => '$data->email'
							 ),
							 array(
									'name' => 'Home Number',
									'value' => '$data->home_number'
							 ),
							 array(
									'name'  => 'Mobile Number',
									'value' => '$data->mobile_number'
							 ),
							 array(
									'class' => 'CButtonColumn',
									'template' => '{delete}{update}'
							 
							 )
							 
					),
	
    ));
	echo CHtml::link('Export to CSV',array('phonebook/exportToCsv')).'                      ';
	echo CHtml::link('Import from CSV',array('phonebook/uploadFiles'));
?>