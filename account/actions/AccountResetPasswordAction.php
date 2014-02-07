<?php

/**
 * AccountResetPasswordAction
 *
 * @property AccountController $controller
 * @property array|string $returnUrl
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package yii-account-module
 */
class AccountResetPasswordAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'account.views.account.reset_password';

    /**
     * @var string
     */
    public $formClass = 'AccountResetPassword';

    /**
     * User clicked a link, check if it's valid and allow them to reset their password
     *
     * @param $id
     * @param $token
     */
    public function run($id, $token)
    {
        // redirect if logged in
        if (!Yii::app()->user->isGuest)
            $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));

        /** @var AccountResetPassword $accountResetPassword */
        $accountResetPassword = new $this->formClass();
        $accountResetPassword->userClass = $this->controller->userClass;
        $accountResetPassword->userIdentityClass = $this->controller->userIdentityClass;
        $accountResetPassword->passwordField = $this->controller->passwordField;

        // redirect if the key is invalid
        if (!$accountResetPassword->checkToken($id, $token)) {
            Yii::app()->user->addFlash(Yii::t('account', 'Invalid key.'), 'error');
            $this->controller->redirect(Yii::app()->user->loginUrl);
        }

        // collect user input
        if (isset($_POST[$this->formClass])) {
            $accountResetPassword->attributes = $_POST[$this->formClass];
            if ($accountResetPassword->save()) {
                Yii::app()->user->addFlash(Yii::t('account', 'Your password has been saved and you have been logged in.'), 'success');
                $this->controller->redirect(Yii::app()->returnUrl->getUrl($this->returnUrl));
            }
        }

        // render the reset password form
        $this->controller->render($this->view, array(
            'accountResetPassword' => $accountResetPassword,
        ));
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        if (!$this->_returnUrl)
            $this->_returnUrl = Yii::app()->homeUrl;
        return $this->_returnUrl;
    }

    /**
     * @param string $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->_returnUrl = $returnUrl;
    }

}
