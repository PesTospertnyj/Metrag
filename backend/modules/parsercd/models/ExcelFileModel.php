<?php
namespace app\modules\parsercd\models;

use yii\base\Model;
use yii\web\UploadedFile;

class ExcelFileModel extends Model
{
/**
* @var UploadedFile
*/
    public $excelFile;

    public function rules()
    {
        return [
        [['excelFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
        //$this->excelFile->saveAs('excel/uploads/' . $this->excelFile->baseName . '.' . $this->excelFile->extension);
        $this->excelFile->saveAs('excel/uploads/' . 'parse' . '.' . $this->excelFile->extension);
        return true;
        } else {
        return false;
    }
}
}