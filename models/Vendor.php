<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:23 AM
 */

namespace app\models;


use yii\base\Model;

class Vendor extends Model
{
    public $Key;
    public $No;
    public $Name;
    public $Generated_Vendor_No;
    public $Address;
    public $Address_2;
    public $Post_Code;
    public $City;
    public $Country_Region_Code;
    public $ShowMap;
    public $Phone_No;
    public $E_Mail;
    public $Fax_No;
    public $Home_Page;
    public $Application_Date;
    public $AGPO_Certificate;
    public $Trade_Licennse_No;
    public $Certificate_of_Incorporation;
    public $Registration_No;
    public $Registration_Date;
    public $Tax_Compliance_Certificate_No;
    public $Tax_Compliance_Expiry_Date;
    public $VAT_Certificate_No;
    public $PIN_No;
    public $No_of_Businesses_at_one_time;
    public $Registration_Status;
    public $Supplier_Type;
    public $Prices_Including_VAT;
    public $Currency_Code;
    public $Payment_Terms_Code;
    public $Payment_Method_Code;
    public $Preferred_Bank_Account_Code;
    public $Location_Code;
    public $Shipment_Method_Code;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['E_Mail','Name','Phone_No','Registration_No','Registration_Date','Tax_Compliance_Certificate_No','Tax_Compliance_Expiry_Date','PIN_No'], 'required']
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