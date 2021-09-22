<?php

namespace app\controllers;

use app\models\Logs;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class LogController extends \JsonRpc2\Controller
{
    public function behaviors(): array
    {
        return [
          'access' => [
            'class' => AccessControl::classname(),
            'rules' => [
              [
                'allow' => true,
                'roles' => ['?'],
                'ips' => ['172.88.*'],
              ],
            ],
            'denyCallback' => function () {
                 throw new ForbiddenHttpException('Access denied: '.\Yii::$app->request->userIP);
            },
          ],
        ];
    }

    public function actionList(int $limit = 10, int $page = 1): array
    {
        return Logs::getFields($limit, $page);
    }

    public function actionSet(string $url): array
    {
        return Logs::setField([
          "url" => $url
        ]);
    }
}