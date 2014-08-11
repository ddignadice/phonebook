<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$userAccount = UserAccount::model()->findByAttributes(array('username' => $this->username));
		if($userAccount == NULL)
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		else if($userAccount->password !== SHA1($this->password))
		{
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
		else
		{
			$this->errorCode=self::ERROR_NONE;
			$this->setState('email', $userAccount->email);
			$this->setState('username', $userAccount->username);
			$this->setState('id', $userAccount->user_account_id);
			return !$this->errorCode;
		}
	}
}