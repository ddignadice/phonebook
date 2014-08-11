<?php

/**
 * This is the model class for table "dossier".
 *
 * The followings are the available columns in table 'dossier':
 * @property integer $dossier_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $title
 * @property string $suffix
 * @property string $street
 * @property string $city
 * @property string $postal_code
 * @property string $country
 * @property integer $user_account_id
 * @property string $email
 * @property string $birthday
 */
class Dossier extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dossier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('first_name, middle_name, last_name, title, suffix, street, city, postal_code, country, user_account_id, email, birthday', 'required'),
			//array('user_account_id', 'numerical', 'integerOnly'=>true),
			array('first_name, middle_name, last_name, street, city, postal_code, country', 'length', 'max'=>250),
			array('title, suffix', 'length', 'max'=>10),
			array('email', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dossier_id, first_name, middle_name, last_name, title, suffix, street, city, postal_code, country, user_account_id, email, birthday', 'safe', 'on'=>'search'),
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
			'dossier_id' => 'Dossier',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'last_name' => 'Last Name',
			'title' => 'Title',
			'suffix' => 'Suffix',
			'street' => 'Street',
			'city' => 'City',
			'postal_code' => 'Postal Code',
			'country' => 'Country',
			'user_account_id' => 'User Account',
			'email' => 'Email',
			'birthday' => 'Birthday',
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

		$criteria->compare('dossier_id',$this->dossier_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('suffix',$this->suffix,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('user_account_id',$this->user_account_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->condition = 'user_account_id='.Yii::app()->user->id; 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dossier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function export()
	{
		Yii::import('ext.ECSVExport');
		$date = date('Y-m-d H:i:s');
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=file-$date.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		$criteria=new CDbCriteria;
		$criteria->condition = 'user_account_id='.Yii::app()->user->id; 
		$data = new CActiveDataProvider('Dossier', array('criteria' => $criteria));
		$csv = new ECSVExport($data);
		$exclude = array('dossier_id');
		$csv->setExclude($exclude);
		$output = $csv->toCSV(); // returns string by default
		echo $output;
	}
	public function insertFromCsv($column)
	{
		$cmd = Yii::app()->db->createCommand();
	  if($column != NULL && $column[1] !== 'first_name' &&
    	 $column[2] !== 'middle_name' && $column[3] !== 'last_name' && 
		 $column[4] !== 'mobile_number' && $column[5] !== 'home_number' &&
		 $column[6] !== 'title' && $column[7] !== 'suffix' &&
		 $column[8] !== 'street' && $column[9] !== 'city' &&
		 $column[10] !== 'postal_code' && $column[11] !== 'country'&&
		 $column[12] !== 'user_account_id' && $column[13] !== 'email' &&
		 $column[14] !== 'birthday'
		 )
	  {
			$cmd->insert('dossier', array(
				'first_name'=> $column[1],
				'middle_name'=> $column[2],
				'last_name'  => $column[3],
				'mobile_number' => $column[4],
				'home_number'   => $column[5],
				'title'         => $column[6],
				'suffix'         => $column[7],
				'street'         => $column[8],
				'city'			  => $column[9],
				'postal_code'     => $column[10],
				'country'		  => $column[11],
				'email'           => $column[13],
				'birthday'		  => $column[14],
				'user_account_id' => Yii::app()->user->id
			));
		}
	}
	public function insertDossier($column)
	{
		$cmd = Yii::app()->db->createCommand();
		$cmd->insert('dossier', array(
				'first_name'=> $column['firstName'],
				'middle_name'=> $column['middleName'],
				'last_name'  => $column['lastName'],
				'mobile_number' => $column['mobile_number'],
				'home_number'   => $column['home_number'],
				'title'         => $column['title'],
				'suffix'         => $column['suffix'],
				'street'         => $column['street'],
				'city'			  => $column['city'],
				'postal_code'     => $column['postal_code'],
				'country'		  => $column['country'],
				'email'           => $column['email'],
				'birthday'		  => $column['birthday'],
				'user_account_id' => Yii::app()->user->id
		));
	}
	public function updateDossier($column, $id)
	{
		$cmd = Yii::app()->db->createCommand();
		$cmd->update('dossier', array(
				'first_name'=> $column['firstName'],
				'middle_name'=> $column['middleName'],
				'last_name'  => $column['lastName'],
				'mobile_number' => $column['mobile_number'],
				'home_number'   => $column['home_number'],
				'title'         => $column['title'],
				'suffix'         => $column['suffix'],
				'street'         => $column['street'],
				'city'			  => $column['city'],
				'postal_code'     => $column['postal_code'],
				'country'		  => $column['country'],
				'email'           => $column['email'],
				'birthday'		  => $column['birthday'],
		), 'dossier_id=:dossier_id', array(':dossier_id'=>$id));
	}
	public function updateCsvFile()
	{
			Yii::import('ext.ECSVExport');
			$filePath = Yii::getPathOfAlias('webroot').'/files/upload-'.Yii::app()->user->username.'.csv';
			$criteria=new CDbCriteria;
			$criteria->condition = 'user_account_id='.Yii::app()->user->id; 
			$data = new CActiveDataProvider('Dossier', array('criteria' => $criteria));
			$csv = new ECSVExport($data);
			$exclude = array('dossier_id');
			$csv->setExclude($exclude);
			$output = $csv->toCSV(); // returns string by default
			$f=fopen($filePath,"a");
			file_put_contents($filePath, '');
			fwrite($f, $output);
			fclose($f);
	}
}
