<?php

/**
 * AccountChangePassword is the data structure for keeping account password form data.
 * It is used by the 'changePassword' action of 'AccountController'.
 *
 * @property AccountUser $user
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountChangePassword extends CFormModel
{

    /**
     * @var string
     */
    public $new_password;

    /**
     * @var string
     */
    public $confirm_password;

    /**
     * @var string
     */
    public $current_password;

    /**
     * @var string
     */
    public $userClass = 'AccountUser';

    /**
     * @var string
     */
    public $passwordField = 'password';

    /**
     * @var AccountUser
     */
    public $_user;

    /**
     * Declares the validation rules.
     * @return array
     */
    public function rules()
    {
        return array(
            array('current_password, new_password, confirm_password', 'required'),
            array('current_password', 'validateCurrentPassword'),
            array('new_password', 'length', 'min' => 5),
            array('confirm_password', 'compare', 'compareAttribute' => 'new_password'),
        );
    }

    /**
     * Validates the users current password.
     */
    public function validateCurrentPassword($attribute, $params)
    {
        if (!$this->user || !CPasswordHelper::verifyPassword($this->current_password, $this->user->password))
            $this->addError($attribute, Yii::t('account', 'Incorrect password.'));
    }

    /**
     * Updates the users password.
     */
    public function save()
    {
        if (!$this->validate())
            return false;

        $this->user->{$this->passwordField} = CPasswordHelper::hashPassword($this->password);
        return $this->user->save(false);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'current_password' => Yii::t('account', 'Current Password'),
            'new_password' => Yii::t('account', 'New Password'),
            'confirm_password' => Yii::t('account', 'Confirm Password'),
        );
    }

    /**
     * @return AccountUser
     */
    public function getUser()
    {
        if (!$this->_user)
            $this->_user = CActiveRecord::model($this->userClass)->findByPk(Yii::app()->user->id);
        return $this->_user;
    }

} 
