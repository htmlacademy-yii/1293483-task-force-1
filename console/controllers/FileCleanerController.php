<?php
namespace console\controllers;

use yii\console\Controller;
use yii\helpers\FileHelper;
use frontend\models\File;

class FileCleanerController extends Controller
{
    public function actionIndex()
    {
        $filesFromUploads = FileHelper::findFiles(dirname(dirname(__DIR__)) . '\frontend\web\uploads');

        $filesFromDB = File::find()->select('file.url')->asArray()->all();
        $filesFromDB = array_column($filesFromDB, 'url');
        $filesFromDB = array_map(function ($file) {
            return $file = dirname(dirname(__DIR__)) . '\frontend\web\\' . str_replace('/', '\\', $file);
        }, $filesFromDB);

        $divergence = array_diff($filesFromUploads, $filesFromDB);

        foreach ($divergence as $file) {
            unlink($file);
        }
    }
}
