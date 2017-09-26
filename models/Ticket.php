<?php

/*
 * is_moderated - ЭТО БИЛЕТ! - некогда поле менять:(
 * $registration = User model() - код взят с форума, некогда менять:(
 * 
 */

namespace app\models;

use Yii;
use app\models\user\User;
use app\models\user\Profile;

class Ticket
{
    public $registration;
    public $imgFileName;
    public $number;
    public $name;

    public function __construct(User $registration)
    {
        $registration->is_moderated = mt_rand(100000, 999999);
        $user = User::findOne(['is_moderated' => $registration->is_moderated]);
        while ($user) {
            $registration->is_moderated = mt_rand(100000, 999999);
            $user = User::findOne(['is_moderated' => $registration->is_moderated]);
        }

        $this->number = $registration->is_moderated;
        $registration->update(false);
        $this->registration = $registration;
        $this->imgFileName = "ticket_".$registration->is_moderated.".jpg";
    }

    public function createImage()
    {
        $userProfile = Profile::findOne(['user_id' => $this->registration->id]);
        $this->name = $userProfile->name.' '.$userProfile->lastName;
        //создаём изображение
        $largeurImage = 840;
        $hauteurImage = 380;
        $im = ImageCreate($largeurImage, $hauteurImage) or die("Ошибка при создании изображения");


        $font = Yii::$app->basePath.'/web/'."fonts/ProximaNovaBold/ProximaNova-Bold.otf";
        $fontThin = Yii::$app->basePath.'/web/'."fonts/ProximaNovaRegular/ProximaNova-Reg.otf";
        $fontThinI = Yii::$app->basePath.'/web/'."fonts/ProximaNovaRegular/ProximaNova-RegIt.otf";

        $fichierSource = Yii::$app->basePath.'/web/'."img/ticket.png";

        $largeurDestination = 840;
        $hauteurDestination = 380;
        $im = ImageCreateTrueColor($largeurDestination, $hauteurDestination) or die("Ошибка при создании изображения");

        $source = ImageCreateFromPng($fichierSource);

        $largeurSource = imagesx($source);
        $hauteurSource = imagesy($source);
        ImageCopyResampled($im, $source, 0, 0, 0, 0, $largeurDestination, $hauteurDestination, $largeurSource, $hauteurSource);


        imagettftext($im, 50, 0, 200, 200, ImageColorAllocate($im, 255, 255, 255), $fontThinI, "№".$this->registration->is_moderated);

        imagettftext($im, 28, 0, 40, 261, ImageColorAllocate($im, 255, 255, 255), $fontThin, $this->name);

        if (file_exists(Yii::$app->basePath.'/web/upload/'.$this->imgFileName))
            unlink(Yii::$app->basePath.'/web/upload/'.$this->imgFileName);

        $filename = Yii::$app->basePath.'/web/upload/'.$this->imgFileName;

        return imagepng($im, $filename);
    }

    public function sendToEmail()
    {
        return Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['email'])
                ->setTo($this->registration->email)
                ->setSubject('Билет на "'.Yii::$app->params['siteTitle'].'"')
                ->attach(Yii::$app->basePath.'/web/upload/'.$this->imgFileName)
                ->attach(Yii::$app->basePath.'/web/img/Pamyatka_uchastnika.pdf')
                ->setHtmlBody('Добрый день, '.$this->name.'!<br><br>'
                    .'Спасибо за проявленный интерес к '.Yii::$app->params['siteTitle'].'! В приложении к письму вы найдёте билет на мероприятие и памятку участника.<br><br>'
                    .'Увидимся на площадке!<br>')
                ->send();
    }

}