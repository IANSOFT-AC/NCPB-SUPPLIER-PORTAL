<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$webroot = Yii::getAlias(@$webroot);

$this->title = Yii::$app->name ;
?>
<div class="site-index">

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
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}
?>
    

    <div class="body-content">

        <div class="row my-5">
            <div class="col-md-8 text-center offset-md-2">
                <h4 class="display-5">You are not a registered supplier, click button to the right to create a supplier profile</h4>
            </div>
        </div>

        <div class="row">

           <div class="col-md-6">
                <img src="<?= $webroot ?>/svgs/profile.svg" class="img-fluid" />
           </div>

           <div class="col-md-6 justify-content-center py-4 text-center ">

                <?= Html::a('Create Supplier Profile', ['create'],['class' => 'btn btn-lg btn-outline-success']); ?>
           </div>

           
           
        </div>

    </div>
</div>
