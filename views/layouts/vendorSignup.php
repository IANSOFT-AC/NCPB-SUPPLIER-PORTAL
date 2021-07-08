<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/21/2020
 * Time: 4:19 PM
 */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\BsAsset;
use common\widgets\Alert;

BsAsset::register($this);
$this->title = 'NCBP -  E-Procurement';


$webroot = Yii::getAlias(@$webroot);
$absoluteUrl = \yii\helpers\Url::home(true);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- PWA SHIT -->

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#FEF207">
    <link rel="apple-touch-icon" href="/images/manifest/96.png"/>
    <meta name="apple-mobile-web-app-status-bar" content="#01A54F">
    
    <!-- / PWA SHIT -->
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<nav class="navbar navbar-expand-md bg-success navbar-dark fixed-top ">
    <div class="container">
        <a href="#" class="navbar-brand">
            <img src="<?= $webroot ?>/images/Logo.jpg" alt="NCPB LOGO" class="rounded-circle" width="50" height="70">
            <h3 class="d-inline align-middle">Supplier Portal</h3>
        </a>
   
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active">Profile</a>
                </li>
                 <li class="nav-item">
                    <a href="#" class="nav-link">Contracts</a>
                </li>
                 <li class="nav-item">
                    <a href="#" class="nav-link">Invoices</a>
                </li>
                 <li class="nav-item">
                    <a href="#" class="nav-link">Documents</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<section class="signup bg-light my-5 p-5 text-center">
    <div class="container ">

       
         <div class="row">
            <div class="col-md-5 d-none d-md-block">
                <h1 class="display-4"> Welcome! </h1>
                <img src="<?= $webroot ?>/svgs/welcome.svg" class="img-fluid" />
            </div>
             <div class="col-md-7 col-sm-12">
                <h3 class="display-4">Signup as a vendor Today.</h3>
                <div class="card text-center card-form">
                    <div class="card-body">
                         <?= $content?>
                     </div>
                </div>
            </div>
         </div>   

    </div>
 
</section>



</body>
<footer class="footer">
    <strong>Copyright &copy; <span style="color: #02A14E" title="NATION CEREALS AND PRODUCE BOARD">NCPB</span> <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b style="color: darkblue"><?= Yii::signature() ?></b>
    </div>

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>


