<?php
	class PhonebookController extends Controller
	{
		public function actions()
		{
			return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
				),
			);
		}
		public function actionIndex()
		{
			$model = new Dossier('search');
			$model->unsetAttributes();
			if (isset($_GET['Dossier'])) {
				$model->attributes = $_GET['Dossier'];
			}
			$this->render('phonebook', array('model' => $model));
		}
		public function actionExportToCsv()
		{
			Dossier::model()->export();
		}
		public function actionUploadFiles()
		{
		$model=new FileUploads;
        if(isset($_POST['FileUploads']))
        {
				$model->attributes=$_POST['FileUploads'];
				$model->user_account_id = Yii::app()->user->id;
				$model->file_name = CUploadedFile::getInstance($model,'file_name');
				$model->date_uploaded = date('Y-m-d H:i:s');
				$model->file_path = Yii::getPathOfAlias('webroot').'/files/upload-'.Yii::app()->user->username.'.csv';
				$csvData     = array();
				chmod(Yii::getPathOfAlias('webroot').'/files', 0755);
				if($model->save())
				{
				
					$model->file_name->saveAs($model->file_path);
					$file = fopen($model->file_path,"r");
					while(!feof($file))
					{
					$csvData = fgetcsv($file);
					Dossier::model()->insertFromCsv($csvData);
						
					}
					fclose($file);
					Yii::app()->user->setFlash('success', 'File has been imported successfully');
					$this->redirect(array('phonebook/index'));
				}
			}
			$this->render('uploadFile', array('model'=>$model));
		}
		public function actionTemp()
		{
			//chmod(Yii::getPathOfAlias('webroot').'/files', 0777);
			//$filePath = Yii::getPathOfAlias('webroot').'/files/upload-'.Yii::app()->user->username.'.csv';
			//$f=fopen($filePath,"a");
			//fwrite($f, $output);
			//fclose($f);
			/*Yii::import('ext.ECSVExport');
			$filePath = Yii::getPathOfAlias('webroot').'/files/upload-'.Yii::app()->user->username.'.csv';
			$criteria=new CDbCriteria;
			$criteria->condition = 'user_account_id='.Yii::app()->user->id; 
			$data = new CActiveDataProvider('Dossier', array('criteria' => $criteria));
			$csv = new ECSVExport($data);
			$exclude = array('dossier_id');
			$csv->setExclude($exclude);
			$output = $csv->toCSV(); // returns string by default
			$f=fopen($filePath,"a");
			fwrite($f, $output);
			fclose($f);*/
			//Dossier::model()->truncateCsvFile();
			Dossier::model()->updateCsvFile();
		}
		public function actionCreateContact()
		{
			$model = new Dossier();
			$this->render('createContact', array('model' => $model));
		}
		public function actionUpdate($id)
		{
			$model = new Dossier();
			$data  = Dossier::model()->findByAttributes(array('dossier_id' => $id));
			$this->render('updateContact', array('model' => $model, 'data' => $data));
		}
		public function actionAjaxCreateContact()
		{
			if(Yii::app()->request->isAjaxRequest)
			{
				$dossier = array();
				$dossier['firstName']  = $_POST['firstName'];
				$dossier['middleName'] = $_POST['middleName'];
				$dossier['lastName']   = $_POST['lastName'];
				$dossier['suffix']     = $_POST['suffix'];
				$dossier['title']  	   = $_POST['title'];
				$dossier['birthday']   = $_POST['birthday'];
				$dossier['home_number'] = $_POST['home_number'];
				$dossier['mobile_number'] = $_POST['mobile_number'];
				$dossier['email']         = $_POST['email'];
				$dossier['street']        = $_POST['street'];
				$dossier['city']          = $_POST['city'];
				$dossier['postal_code']   = $_POST['postal_code'];
				$dossier['country']		  = $_POST['country'];
				Dossier::model()->insertDossier($dossier);
				Dossier::model()->updateCsvFile();
				Yii::app()->user->setFlash('success', 'New account has been successfully registered. Please login using your registered username and password.');
				$json['redirect'] = $this->createUrl('/site/login');
				echo json_encode($json);
				
			}
			else
			{
				$this->redirect(array('site/login'));
			}
		}
		public function actionAjaxUpdateContact()
		{
			if(Yii::app()->request->isAjaxRequest)
			{
				$dossier = array();
				$dosier['dossierId']   = $_POST['dossierId'];
				$dossier['firstName']  = $_POST['firstName'];
				$dossier['middleName'] = $_POST['middleName'];
				$dossier['lastName']   = $_POST['lastName'];
				$dossier['suffix']     = $_POST['suffix'];
				$dossier['title']  	   = $_POST['title'];
				$dossier['birthday']   = $_POST['birthday'];
				$dossier['home_number'] = $_POST['home_number'];
				$dossier['mobile_number'] = $_POST['mobile_number'];
				$dossier['email']         = $_POST['email'];
				$dossier['street']        = $_POST['street'];
				$dossier['city']          = $_POST['city'];
				$dossier['postal_code']   = $_POST['postal_code'];
				$dossier['country']		  = $_POST['country'];
				Dossier::model()->updateDossier($dossier, $_POST['dossierId']);
				Dossier::model()->updateCsvFile();
				Yii::app()->user->setFlash('success', 'Record has been successfully updated');
				$json['redirect'] = $this->createUrl('/phonebook/index');
				echo json_encode($json);
				
			}
			else
			{
				$this->redirect(array('site/login'));
			}
		}
		public function actionDelete($id)
		{
			$cmd = Yii::app()->db->createCommand();
			$cmd->delete('dossier', 'dossier_id=:dossier_id', array(':dossier_id' => $id));
			Dossier::model()->updateCsvFile();
			Yii::app()->user->setFlash('success', 'Record has been successfully deleted');
			$this->redirect(array('phonebook/index'));
		}
		
	
	}


?>