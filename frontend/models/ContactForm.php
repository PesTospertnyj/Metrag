<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'phone', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => Yii::t('yii', 'Verification Code'),
            'name' => Yii::t('yii', 'Name'),
            'email' => Yii::t('yii', 'Email'),
            'phone' => Yii::t('yii', 'Phone'),
            'subject' => Yii::t('yii', 'Subject'),
            'body' => Yii::t('yii', 'Body'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        /*
        $mailer = Yii::$app->mailer;
        $message = $mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body);

        $logger = new \Swift_Plugins_Loggers_ArrayLogger();
        $mailer->getSwiftMailer()->registerPlugin(new \Swift_Plugins_LoggerPlugin($logger));
        if (!$message->send()) {
            var_dump($logger->dump());
        }
        else return true;
*/      $mail = 'skovorodkinsergey86@gmail.com';
        return Yii::$app->mailer->compose()
            ->setTo($mail)
            //->setFrom([$this->email => $this->name])
            ->setFrom($email)
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->setReplyTo([$this->email => $this->name])
            ->send();
    }
}
