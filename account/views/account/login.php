<?php
/**
 * @var $this AccountController
 * @var $accountLogin AccountLogin
 * @var $recaptcha string
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-account
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-account/master/LICENSE
 *
 * @package yii-account-module
 */

$this->pageTitle = Yii::t('account', 'Login');

/** @var AccountActiveForm $form */
$form = $this->beginWidget('account.components.AccountActiveForm', array(
    'id' => 'accountLogin-form',
));
echo $form->errorSummary($accountLogin);

echo $form->textFieldControlGroup($accountLogin, 'username');
echo $form->passwordFieldControlGroup($accountLogin, 'password');
echo $form->checkBoxControlGroup($accountLogin, 'remember');

//if ($accountLogin->scenario == 'recaptcha') {
//    echo CHtml::activeLabel($accountLogin, 'recaptcha');
//    $this->widget('account.components.AccountReCaptchaInput', array('model' => $accountLogin));
//    echo CHtml::error($accountLogin, 'recaptcha');
//}

echo CHtml::tag('div', array('class' => 'form-actions'), implode(' ', array(
    TbHtml::submitButton(Yii::t('app', 'Login'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::link(Yii::t('app', 'Sign Up'), array('/account/signUp'), array('class' => 'btn')),
    TbHtml::link(Yii::t('app', 'Lost Password'), array('/account/lostPassword'), array('class' => 'btn')),
)));
$this->endWidget();