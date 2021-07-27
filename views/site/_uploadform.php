<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">



                    <?php
                    $form = ActiveForm::begin(['id' => 'SupplierDocuments','options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class="row">
                    <div class="col-md-12">



                            <table class="table">
                                <tbody>

                                

                               
                                <tr>
                                    <?= $form->field($model, 'Supplier_No')->textInput(['readonly' => 'true','value' =>  Yii::$app->user->identity->VendorId]) ?>
                                </tr>
                                
                                
                                <tr>
                                    <?= $form->field($model, 'attachmentfile')->fileInput(['accept' => 'application/*']) ?>
                                </tr>

                                











                                </tbody>
                            </table>



                    </div>




                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php

$script = <<<JS
    $(function(){
        $('#qualification-qualification_code').on('change', function(){
            var selected =  $('#qualification-qualification_code').find(':selected').text();
            $('#qualification-description').val(selected);
            
        });

        $('#qualification-qualification_code').select2();
    });
JS;

$this->registerJs($script);

?>


