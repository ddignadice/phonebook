<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
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

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->redirect(array('site/login'));
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(Yii::app()->user->id !== NULL)
		{
			$this->redirect(array('phonebook/index'));
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(array('phonebook/index'));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	public function actionRegister()
	{
		$model = new UserAccount();
		$this->render('register', array('model' => $model));
	}
	public function actionAjaxRegister()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$userAccount = array();
			$userAccount['username'] = $_POST['username'];
			$userAccount['email']    = $_POST['email'];
			$userAccount['password'] = sha1($_POST['password']);
			UserAccount::model()->insertUserAccount($userAccount);
			Yii::app()->user->setFlash('success', 'New account has been successfully registered. Please login using your registered username and password.');
			$json['redirect'] = $this->createUrl('/site/login');
			echo json_encode($json);
		}
		else
		{
			$this->redirect(array('site/login'));
		}
	}
	

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('site/login'));
	}
}