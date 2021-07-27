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

$this->title = 'Create Supplier Upload';
$this->params['breadcrumbs'][] = ['label' => 'Supplier Upload', 'url' => ['upload']];
$this->params['breadcrumbs'][] = ['label' => 'Supplier Uploads', 'url' => ['uploads']];
//$this->params['breadcrumbs'][] = $this->title;

$model->isNewRecord = true;


?>
<div>

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_uploadform', [
        'model' => $model
    ]) ?>

</div>
