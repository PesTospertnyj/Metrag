<?php

namespace console\controllers;

use yii\helpers\BaseFileHelper;

class RealtyController extends \yii\console\Controller
{
    private $realtyImagesFullPath;

    public function __construct($id, $module, $config = [])
    {
        $param = null;
        if (\Yii::$app->hasModule('yii2images')) {
            $module = \Yii::$app->getModule('yii2images');
            if ($module->hasProperty('imagesStorePath', true, false)) {
                $param = $module->imagesStorePath;
            }
        }

        if ($param !== null) {
            $this->realtyImagesFullPath = \Yii::getAlias('@fullRootPath') . '/backend/web/' . $param;
        }

        parent::__construct($id, $module, $config);
    }

    public function actionRemove($maxUpdated = null)
    {
        if (!($this->realtyImagesFullPath && is_dir($this->realtyImagesFullPath))) {
            $this->stdout("Directory not exists.\n");

            return 1;
        }

        if ($maxUpdated === null || !$this->isValidDate($maxUpdated)) {
            $this->stdout($this->ansiFormat("The first parameter is required and must be in the format 'YYYY-MM-DD' (for example, 2017-12-30)!\n"));

            return 1;
        }

        foreach (['rent', 'apartment', 'building', 'house', 'area', 'commercial'] as $model) {
            $imgCount = 0;
            $data = $this->getDataToRemove($model, $maxUpdated);

            $deleteImgSqlCommand = \Yii::$app->db->createCommand('DELETE FROM image WHERE id = :id');
            $deleteModelSqlCommand = \Yii::$app->db->createCommand("DELETE FROM $model WHERE id = :id");

            foreach ($data as $modelId => $images) {
                $path = null;
                foreach ($images as $img) {
                    $imgCount++;
                    $path = $img['filePath'];

                    $this->removeImageFile($img['filePath']);
                    $deleteImgSqlCommand->bindValue(':id', $img['imageId'])->execute();
                }
                if ($path !== null) {
                    $dir = dirname($this->realtyImagesFullPath . '/' . $path);
                    if (is_dir($dir)) {
                        $isDirEmpty = !(new \FilesystemIterator($dir))->valid();
                        if ($isDirEmpty) {
                            rmdir($dir);
                        }
                    }
                }

                // remove model with images
                $deleteModelSqlCommand->bindValue(':id', $modelId)->execute();
            }

            // remove other models
            \Yii::$app->db->createCommand("DELETE FROM $model WHERE date_modified < :dateModified", [
                'dateModified' => $maxUpdated,
            ])->execute();

            $this->stdout("$model. Removed images: $imgCount\n");
            $this->stdout("$model. Removed models with images: " . count($data) . "\n");
        }

        $this->stdout("Complete.\n");

        return 0;
    }

    private function removeImageFile($imageFilePath)
    {
        $file = $this->realtyImagesFullPath . "/$imageFilePath";
        if (file_exists($file)) {
            unlink($file);
        }
    }

    private function getDataToRemove($modelName, $maxUpdatedDateStr)
    {
        $result = [];

        $sql = "SELECT i.id, i.itemId, i.filePath
            FROM image i 
            INNER JOIN $modelName m ON i.itemId = m.id
            WHERE i.modelName = :modelName
            AND m.enabled = 0
            AND m.date_modified < :dateModified";

        $data = \Yii::$app->db->createCommand($sql, [
            'modelName' => $modelName,
            'dateModified' => $maxUpdatedDateStr,
        ])->queryAll();

        foreach ($data as $item) {
            if (!array_key_exists($item['itemId'], $result)) {
                $result[$item['itemId']] = [];
            }

            $result[$item['itemId']][] = [
                'imageId' => $item['id'],
                'filePath' => $item['filePath'],
            ];
        }

        return $result;
    }

    protected function isValidDate($dateStr, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $dateStr);
        return $d && $d->format($format) === $dateStr;
    }
}