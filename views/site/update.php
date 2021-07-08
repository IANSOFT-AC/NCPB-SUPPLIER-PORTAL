<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:29 PM
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AgendaDocument */

$this->title = 'Update Supplier Application';
$this->params['breadcrumbs'][] = ['label' => 'Supplier', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Update Supplier Application', 'url' => ['update']];
//$this->params['breadcrumbs'][] = $this->title;

$model->isNewRecord = true;

//$model->Registration_Date = date('Y-m-d', strtotime($model->Registration_Date));

?>
<div class="leave-document-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'towns' => $towns,
        'countries' => $countries,
        'scategories' => $scategories,
        'locations' => $locations,
        'ShipmentMethods' => $ShipmentMethods,
        'paymentTerms' => $paymentTerms,
        'paymentMethods' => $paymentMethods,
        'VendorBankAccounts' => $VendorBankAccounts
    ]) ?>

</div>
