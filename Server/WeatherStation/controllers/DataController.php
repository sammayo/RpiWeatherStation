<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class DataController extends Controller
{
    public function actionSave()
    {
	$jsonData = Yii::$app->request->get('data');
	$logPath = realpath(Yii::$app->basePath . '/../dataLog');
	$logFile = fopen($logPath, 'a');
	fwrite($logFile, $jsonData);
	fwrite($logFile, "\n");
	fclose($logFile);
    }

    public function actionReset()
    {
	$logPath = realpath(Yii::$app->basePath . '/../dataLog');
	$logFile = fopen($logPath, 'w');
	fclose($logFile);
    }

    public function actionGet()
    {
	$logPath = realpath(Yii::$app->basePath . '/../dataLog');
	$jsonArray = file($logPath);
	foreach($jsonArray as $line_num => $line)
	{
	    $jsonData = json_decode($line, true);
	    var_dump($jsonData);
	}
    }
}
