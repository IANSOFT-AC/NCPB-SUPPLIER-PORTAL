<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/23/2020
 * Time: 4:29 PM
 */

/* @var $this yii\web\View */

$this->title = Yii::$app->params['generalTitle'].' - File Reader';
?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?= \yii\helpers\Html::a('Go Back',['uploads'],['class' => ' back btn btn-outline-primary push-right']) ?>
                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Supplier Document</h3>

                </div>
                <div class="card-body" >




                    <iframe src="data:application/pdf;base64,<?= $content; ?>" height="950px" width="100%"></iframe>



                </div>
            </div>
        </div>
    </div>


   


   







