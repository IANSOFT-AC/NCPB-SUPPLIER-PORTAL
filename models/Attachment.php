<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 5/11/2020
 * Time: 3:51 AM
 */

namespace app\models;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Attachment extends Model
{

    /**
     * @var UploadedFile
     */
public $Supplier_No;
public $Name;
public $File_path;
public $Key;
public $attachmentfile;
public $isNewRecord;


    public function rules()
    {
        return [
            [['attachmentfile'],'file','maxFiles'=> Yii::$app->params['maxUploadFiles']],
            [['attachmentfile'],'file','mimeTypes'=> Yii::$app->params['QualificationsMimeTypes']],
            [['attachmentfile'],'file','maxSize' => '5120000'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'attachmentfile' => 'Document Attachment',
        ];
    }

    public function upload()
    {
        $model = $this;

        $imageId = Yii::$app->security->generateRandomString(8);

        $imagePath = Yii::getAlias('@app/web/uploads/'.$imageId.'.'.$this->attachmentfile->extension);
        $navPath = \yii\helpers\Url::home(true).'uploads/'.$imageId.'.'.$this->attachmentfile->extension; // Readable from nav interface


        //return($model); 

        if($model->validate()){
            // Check if directory exists, else create it
            if(!is_dir(dirname($imagePath))){
                FileHelper::createDirectory(dirname($imagePath));
            }

            $this->attachmentfile->saveAs($imagePath);

            //Post to Nav
            if(!$model->Key) // A create scenario
            {
                $service = Yii::$app->params['ServiceName']['SupplierAttachments'];
                $model->File_path = $navPath;
                $result = Yii::$app->navhelper->postData($service, $model);
                
                return $result;
                
            }elseif($model->Key) //An update scenario
            {
                $service = Yii::$app->params['ServiceName']['SupplierAttachments'];
                $model->File_path = $navPath;
                $result = Yii::$app->navhelper->updateData($service, $model);
                
                return $result;
                
            }
            return true;
        }else{
            return false;
        }
    }

    public function getPath($DocNo=''){
        if(!$DocNo){
            return false;
        }
        $service = Yii::$app->params['ServiceName']['LeaveAttachments'];
        $filter = [
            'Document_No' => $DocNo
        ];

        $result = Yii::$app->navhelper->getData($service,$filter);
        if(is_array($result)) {
            return basename($result[0]->File_path);
        }else{
            return false;
        }

    }

    public function readAttachment($Key)
    {
        $service = Yii::$app->params['ServiceName']['SupplierAttachments'];
       

        $result = Yii::$app->navhelper->readByKey($service,$Key);

        $path = $result->File_path;
        
        $binary = file_get_contents($path);
        $content = chunk_split(base64_encode($binary));
        return $content;
        
    }

    public function getAttachment($Name,$Supplier_No)
    {

        $service = Yii::$app->params['ServiceName']['SupplierAttachments'];

        $filter = [
            'Name' => $Name,
            'Supplier_No' => $Supplier_No
        ];

        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            return $result[0];
        }else{
            return false;
        }

    }

    public function getFileProperties($binary)
    {
        $bin  = base64_decode($binary);
        $props =  getImageSizeFromString($bin);
        return $props['mime'];
    }
}