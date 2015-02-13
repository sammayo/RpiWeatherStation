<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionGet()
    {
        $data = Yii::$app->request->get('data');
        return $this->render('get', ['data' => $data,]);
    }
}
