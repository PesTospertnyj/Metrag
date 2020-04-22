<?php

namespace api\modules\v1\controllers;

use common\models\User;
use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class JwtController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'optional' => ['auth'],
            'except' => ['auth'],
        ];

        return $behaviors;
    }

    public function beforeAction($action)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * @return Response
     * @throws ForbiddenHttpException
     * @throws Exception
     */
    public function actionAuth()
    {
        $data = Yii::$app->request->post();

        $user = User::findByUsername($data['username']);

        if (!$user) {
            throw new ForbiddenHttpException(json_encode([
                'message' => 'User not found'
            ]));
        }

        if (!$user->validatePassword($data['password'])) {
            throw new ForbiddenHttpException(json_encode([
                'message' => 'Password is not valid'
            ]));
        }


        /** @var Jwt $jwt */
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $time = time();

        $url = Url::base('https');

        $token = $jwt->getBuilder()
            ->setIssuer($url)
            ->setAudience($url)
            ->setId(
                '4f1g23a12aa',
                true
            )
            ->setIssuedAt($time)
            ->setExpiration($time + 3600)
            ->set('uid', $user->getPrimaryKey())
            ->set('username', $user->username)
            ->sign($signer, $jwt->key)
            ->getToken();

        return $this->asJson([
            'token' => (string)$token,
        ]);
    }

    /**
     * @return Response
     */
    public function actionData()
    {
        return $this->asJson([
            'success' => true,
        ]);
    }
}
