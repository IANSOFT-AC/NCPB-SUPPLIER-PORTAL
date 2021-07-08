<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/21/2020
 * Time: 4:19 PM
 */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminlteAsset;
use common\widgets\Alert;

AdminlteAsset::register($this);
$this->title = 'NCBP -  Extranet Login';
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
<body class="hold-transition login-page">
<?php $this->beginBody() ?>


<div class="login-logo" style="margin-top: 30px; margin-bottom: 20px">
    <a href="javascript:void()"><b><?= $this->title ?></a>
</div>
<!-- /.login-logo -->
<div class="card">
    <div class="card-body login-card-body">
        <!--<p class="login-box-msg">Sign in to start your session</p>-->

        <?= $content?>

        <!--<div class="social-auth-links text-center mb-3">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-primary">
                <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
                <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a>
        </div>-->

    </div>
    <!-- /.login-card-body -->
</div>
</div>


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


