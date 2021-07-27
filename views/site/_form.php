<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:41 AM
 */




use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
//$this->title = Yii::$app->params['generalTitle'].' - Supplier Details'
?>
<h2 class="title">Supplier : <?= $model->Name ?></h2>

<?php


if(Yii::$app->session->hasFlash('success')){
    print ' <div class="alert alert-success alert-dismissable">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                                 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
}else if(Yii::$app->session->hasFlash('error')){
    print ' <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Error!</h5>
                                 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
}
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin([ 
                'id' => 'form-signup',
                'layout' => 'horizontal',
                'enableClientValidation' => true,
                'encodeErrorSummary' => false
            ]); ?>
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">General Details - Vendor <?= $model->No ?></h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Name')->textInput([]) ?>
                            

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Generated_Vendor_No')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                           
                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Address</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">

                            <?= $form->field($model, 'Address')->textInput([]) ?>
                            <?= $form->field($model, 'Address_2')->textInput([]) ?>
                            <?= $form->field($model, 'Post_Code')->dropDownList($towns,['prompt' => 'Select ...']) ?>
                            <?= $form->field($model, 'City')->textInput([]) ?>

                            <?= $form->field($model, 'Country_Region_Code')->dropDownList($countries,['prompt' => 'Select ... ']) ?>


                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Phone_No')->textInput(['maxlength'=> '15']) ?>
                            <?= $form->field($model, 'E_Mail')->textInput(['type' => 'email']) ?>
                            <?= $form->field($model, 'Home_Page')->textInput(['maxlength'=> '100']) ?>
                           



                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card card-success ">
            <div class="card-header">
                <h3 class="card-title">Procurement Details</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Application_Date')->textInput(['readonly' => true, 'disabled'=> 'true']) ?>
                            <?= $form->field($model, 'AGPO_Certificate')->textInput([]) ?>
                            <?= $form->field($model, 'Trade_Licennse_No')->textInput([]) ?>
                            <?= $form->field($model, 'Registration_No')->textInput([]) ?>
                            <?= $form->field($model, 'Registration_Date')->textInput(['type' => 'date']) ?>
                            



                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Tax_Compliance_Certificate_No')->textInput([]) ?>
                            <?= $form->field($model, 'Tax_Compliance_Expiry_Date')->textInput(['type' => 'date' ]) ?>
                            <?= $form->field($model, 'VAT_Certificate_No')->textInput([]) ?>
                            <?= $form->field($model, 'PIN_No')->textInput([]) ?>
                            <?= $form->field($model, 'No_of_Businesses_at_one_time')->textInput([]) ?>
                            <?= $form->field($model, 'Registration_Status')->textInput(['readonly' => true, 'disabled'=> 'true']) ?>


                        </div>
                    </div>
                </div>







            </div>
        </div>

       



        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Invoicing</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Supplier_Type')->dropDownList($scategories,['prompt' => 'Select ...']) ?>
                           

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Prices_Including_VAT')->checkbox(['Prices_Including_VAT',$model->Prices_Including_VAT]) ?>
                            

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Payments</h3>


                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>


            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Payment_Terms_Code')->dropDownList($paymentTerms,['prompt' => 'Select ...']) ?>
                           
                            

                        </div>
                        <div class="col-md-6">
                             <?= $form->field($model, 'Payment_Method_Code')->dropDownList($paymentMethods,['prompt' => 'select ...']) ?>
                            <?php $form->field($model, 'Preferred_Bank_Account_Code')->dropDownList($VendorBankAccounts,['prompt' => 'Select ...']) ?>
                            

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Receiving</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Location_Code')->dropDownList($locations,['prompt' => 'Select ...']) ?>
                           

                        </div>
                        <div class="col-md-6">
                           
                            <?= $form->field($model, 'Shipment_Method_Code')->dropDownList($ShipmentMethods,['prompt' => 'Select ...']) ?>
                            


                        </div>
                    </div>
                </div>

            </div>
        </div>
		/* Supplier Uploads */
		<div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Supplier Uploads</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Location_Code')->dropDownList($locations,['prompt' => 'Select ...']) ?>
                           

                        </div>
                        <div class="col-md-6">
                           
                            <?= $form->field($model, 'Shipment_Method_Code')->dropDownList($ShipmentMethods,['prompt' => 'Select ...']) ?>
                            


                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group">
                    <?= Html::submitButton('Save Profile', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
