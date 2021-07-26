<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:23 AM
 */

namespace app\models;


use Yii;
use yii\base\Model;


class Vendorquote extends Model
{
    public $Key;
    public $Vendor_No;
    public $Vendor_Name;
    public $Line_No;
    public $Item_No;
    public $Item_Name;
    public $Description;
    public $Quoted_Amount;
    public $VAT_Inclusive;
    public $VAT_Amount;
    public $Lead_Time;
    public $Quote_No;
    public $Quantity;
    public $Status;
    public $isNewRecord;

    public function rules()
    {
        return [

            ['Quoted_Amount', 'required'],
            ['Quoted_Amount', 'number']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            
        ];
    }

}