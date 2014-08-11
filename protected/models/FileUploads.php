<?php

/**
 * This is the model class for table "file_uploads".
 *
 * The followings are the available columns in table 'file_uploads':
 * @property integer $file_uploads_id
 * @property integer $user_account_id
 * @property string $file_name
 * @property string $file_path
 */
class FileUploads extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'file_uploads';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_account_id, file_name, file_path', 'required'),
			array('user_account_id', 'numerical', 'integerOnly'=>true),
			array('file_name', 'file', 'types'=>'csv'),
			//array('file_name, file_path', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('file_uploads_id, user_account_id, file_name, file_path', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'file_uploads_id' => 'File Uploads',
			'user_account_id' => 'User Account',
			'file_name' => 'File Name',
			'file_path' => 'File Path',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('file_uploads_id',$this->file_uploads_id);
		$criteria->compare('user_account_id',$this->user_account_id);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_path',$this->file_path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FileUploads the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
