<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 03/02/15
 * Time: 13:16
 */

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\validators\FileValidator;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;
use Yii;

class FileController extends Controller
{
    /**
     * @var bool
     */
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['upload'],
                'rules' => [
                    [
                        'actions' => ['upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionUpload()
    {
        Yii::$app->response->format = 'json';

        $validator = new FileValidator(['mimeTypes' => 'image/gif image/jpeg image/bmp image/png']);
        $file = UploadedFile::getInstanceByName('file');

        if (false === $validator->validate($file, $error)) {
            throw new HttpException(400, $error);
        }

        // url safe name
        $name = sha1($file->getBaseName()).'.'.$file->getExtension();
        $folder = '/upload/'.uniqid().'/';

        // create folder
        mkdir(Yii::getAlias('@webroot').$folder);

        if (false === $file->saveAs(Yii::getAlias('@webroot').$folder.$name)) {
            throw new HttpException(500, 'Ошибка при сохранении файла');
        }

        return ['url' => $folder.$name];
    }
}