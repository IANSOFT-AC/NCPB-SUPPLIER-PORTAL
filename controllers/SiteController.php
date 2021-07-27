<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\Vendor;
use app\models\Vuser;
use app\models\Vendoruser;
use app\models\VerifyEmailForm;
use app\models\VendorLoginForm;
use app\models\VendorSignupForm;
use app\models\PasswordResetRequestForm;
use app\models\ResendVerificationEmailForm;
use app\models\ResetPasswordForm;
use app\models\Attachment;

use yii\web\UploadedFile;


use yii\helpers\Html;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index'],
                'rules' => [
                    [
                        'actions' => ['logout','profile','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                     [
                        'actions' => ['tenders',],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'download' => ['post'],
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => [
                'list'
                ],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->identity->VendorId)
        {
            $this->redirect(['site/view']);
        }

        return $this->render('index');
    }

     public function actionTenders(){

        if(Yii::$app->user->isGuest)
        {
             $this->layout="external";
        }
       

        return $this->render('tenders');

    }


    public function actionUploads()
    {
        $service = Yii::$app->params['ServiceName']['SupplierAttachmentTypes'];
        $uploads = Yii::$app->navhelper->getData($service);

        $model = new Attachment();

        return $this->render('uploads', [
            'uploads' => $uploads,
            'model' => $model
        ]);
    }


    public function actionAttach()
    {
        $model = new Attachment();
        $model->Name = Yii::$app->request->get('NAME');
        $model->Key = (Yii::$app->request->get('Key'))?Yii::$app->request->get('Key'):null;
        $service = Yii::$app->params['ServiceName']['SupplierAttachments'];
        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Attachment'],$model)){
           

             if(!empty($_FILES['Attachment']['name']['attachmentfile'])){
                $model->attachmentfile = UploadedFile::getInstance($model, 'attachmentfile');
                $model->upload();
            }
            $result = Yii::$app->navhelper->postData($service,$model);

            if(is_object($result)){

                Yii::$app->session->setFlash('success','Document Added Successfully',true);
                return $this->redirect(['uploads']);

            }else{

                Yii::$app->session->setFlash('error','Error Adding Document: '.$result,true);
                return $this->redirect(['uploads']);

            }

        }//End Saving experience

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('createupload', [
                'model' => $model

            ]);
        }

        return $this->render('createupload',[
            'model' => $model,
        ]);
    }


/*Created Supplier Profle*/
   public function actionCreate(){

       $model = new Vendor();
       $service = Yii::$app->params['ServiceName']['SupplierCard'];

       

        $result =  Yii::$app->navhelper->postData($service,[]);

        if(is_object($result) )
            {


                //Update Vuser Model

                $vuser = Vendoruser::findOne(['id' => Yii::$app->user->identity->id]);
                $vuser->VendorId = $result->No;
                $vuser->save(false);
                
                    

                Yii::$app->navhelper->loadmodel($result,$model);
            }else {
                Yii::$app->session->setFlash('error', $result);
                return $this->redirect(['index']);
            }

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Vendor'],$model) ){


            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->findOne($service, 'No', $model->No);
            $model->Key = $refresh->Key;
            
            $result = Yii::$app->navhelper->updateData($service,$model);
            if(!is_string($result)){

                $vuser = Vendoruser::findOne(['id' => Yii::$app->user->identity->id]);
                $vuser->VendorId = $result->No;
                $vuser->save(false);

                Yii::$app->session->setFlash('success','Supplier Data saved Successfully.' );
                return $this->redirect(['view']);

            }else{
                Yii::$app->session->setFlash('error','Error  '.$result );
                return $this->redirect(['index']);

            }

        }

        return $this->render('create',[
            'model' => $model,
            'towns' => $this->getPostcodes(),
            'countries' => $this->getCountries(),
            'scategories' => $this->getSupplierCategories(),
            'locations' =>  $this->getLocations(),
            'ShipmentMethods' => $this->getShipmentMethods(),
            'paymentTerms' => $this->dropdown('PaymentTerms','Code','Description'),
            'paymentMethods' => $this->dropdown('PaymentMethods','Code','Description'),
            'VendorBankAccounts' => $this->dropdown('VendorBankAccountList','Code','Name'),
           
        ]);
    }


    public function actionUpdate(){
       $model = new Vendor();
       $service = Yii::$app->params['ServiceName']['SupplierCard'];
       $model->isNewRecord = false;



        $result = Yii::$app->navhelper->findOne($service, 'No',Yii::$app->user->identity->VendorId);

        if($result->Registration_Status == 'Submitted')
        {
            Yii::$app->session->setFlash('info','Submitted:  Your Application has already been submitted and hence cannot be updated. ' );
            return $this->redirect(['index']);
        }

       // Yii::$app->recruitment->printrr($result);

        if(is_object($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result,$model);
        }else{
            Yii::$app->session->setFlash('error', $result);
             return $this->render('update',[
                    'model' => $model,
                    'towns' => $this->getPostcodes(),
                    'countries' => $this->getCountries(),
                    'scategories' => $this->getSupplierCategories(),
                    'locations' =>  $this->getLocations(),
                    'ShipmentMethods' => $this->getShipmentMethods(),
                    'paymentTerms' => $this->dropdown('PaymentTerms','Code','Description'),
                    'paymentMethods' => $this->dropdown('PaymentMethods','Code','Description'),
                    'VendorBankAccounts' => $this->dropdown('VendorBankAccountList','Code','Name'),
        ]);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Vendor'],$model) ){
            
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->findOne($service,'No',Yii::$app->user->identity->VendorId);
            $model->Key = $refresh->Key;

            $result = Yii::$app->navhelper->updateData($service,$model);

            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Record Updated Successfully.' );

                return $this->redirect(['view']);

            }else{
                Yii::$app->session->setFlash('success','Error Updating Record'.$result );
                return $this->render('update',[
                    'model' => $model,
                    'towns' => $this->getPostcodes(),
                    'countries' => $this->getCountries(),
                    'scategories' => $this->getSupplierCategories(),
                    'locations' =>  $this->getLocations(),
                    'ShipmentMethods' => $this->getShipmentMethods(),
                    'paymentTerms' => $this->dropdown('PaymentTerms','Code','Description'),
                    'paymentMethods' => $this->dropdown('PaymentMethods','Code','Description'),
                    'VendorBankAccounts' => $this->dropdown('VendorBankAccountList','Code','Name'),
                ]);

            }

        }


       

        return $this->render('update',[
                'model' => $model,
                    'towns' => $this->getPostcodes(),
                    'countries' => $this->getCountries(),
                    'scategories' => $this->getSupplierCategories(),
                    'locations' =>  $this->getLocations(),
                    'ShipmentMethods' => $this->getShipmentMethods(),
                    'paymentTerms' => $this->dropdown('PaymentTerms','Code','Description'),
                    'paymentMethods' => $this->dropdown('PaymentMethods','Code','Description'),
                    'VendorBankAccounts' => $this->dropdown('VendorBankAccountList','Code','Name'),

        ]);
    }



    /*View SUpplier Profile */
     public function actionView(){
        // Yii::$app->recruitment->printrr(Yii::$app->user->identity->{'User ID'});
        $model = new Vendor();
        $service = Yii::$app->params['ServiceName']['SupplierCard'];

        $supplier = Yii::$app->navhelper->findOne($service, 'No', Yii::$app->user->identity->VendorId);
        //$result = Yii::$app->navhelper->readByKey($service, $Key);


        //load nav result to model
        $model = Yii::$app->navhelper->loadmodel($supplier, $model);

        // Yii::$app->recruitment->printrr($model);

        return $this->render('view',[
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'vendorLogin';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new VendorLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegister()
    {
        $this->layout = 'vendorSignup';
        $model = new VendorSignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->redirect(['index']);
        }

        return $this->render('register',[
            'model' => $model,
        ]);
    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
         $this->layout = 'vendorLogin';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'vendorLogin';
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }


        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
         $this->layout = 'vendorLogin';
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

   /* public function goHome()
    {
         return $this->redirect(['index']);
    }*/

     public function welcome()
    {
         return $this->redirect(['procurement/create']);
    }

    /*Get Postal Code */

    public function getPostcodes(){
        $service = Yii::$app->params['ServiceName']['categoryTowns'];
        $result = \Yii::$app->navhelper->getData($service, []);
        return Yii::$app->navhelper->refactorArray($result,'Town_Code','Town_Name');
    }

    public function getCountries(){
        $service = Yii::$app->params['ServiceName']['Countries'];
        $result = \Yii::$app->navhelper->getData($service, []);
        return Yii::$app->navhelper->refactorArray($result,'Code','Name');
    }

    public function getSupplierCategories(){
        $service = Yii::$app->params['ServiceName']['SupplierCategory'];
        $result = \Yii::$app->navhelper->getData($service, []);
        return Yii::$app->navhelper->refactorArray($result,'Category_Code','Description');
    }

     public function getLocations(){
        $service = Yii::$app->params['ServiceName']['LocationList'];
        $result = \Yii::$app->navhelper->getData($service, []);
        return Yii::$app->navhelper->refactorArray($result,'Code','Name');
    }

     public function getShipmentMethods(){
        $service = Yii::$app->params['ServiceName']['ShipmentMethods'];
        $result = \Yii::$app->navhelper->getData($service, []);
        return Yii::$app->navhelper->refactorArray($result,'Code','Description');
    }

    public function dropdown($service,$from,$to){
        $service = Yii::$app->params['ServiceName'][$service];
        $result = \Yii::$app->navhelper->getData($service, []);
        return Yii::$app->navhelper->refactorArray($result,$from,$to);
    }

     public function actionList(){

        $service = Yii::$app->params['ServiceName']['AdvertisedTenderList'];
        $filter = [
            //'Vendor_No' => Yii::$app->user->identity->vendor->Generated_Vendor_No,
        ];
        
        $results = \Yii::$app->navhelper->getData($service,$filter);
        // Yii::$app->recruitment->printrr($results);
        $result = [];
        foreach($results as $item){

            if(empty($item->No))
            {
                continue;
            }


            $ApprovalLink = $updateLink = $ViewLink =  '';
            // $ViewLink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->Appraisal_Code ],['title' => 'View Appriasal Card..','class'=>'btn btn-outline-primary btn-xs']);
            $downloadLink = Html::a('<i class="fas fa-download"></i> Download ',['download'],[
                'title' => 'Download Tender Documents',
                'class'=>'btn update btn-outline-success btn-xs',
                'data' => [
                    'method' => 'POST',
                    'params' => [
                        'path'=> $item->Attachment_File_Path
                    ],
                ]
            ]);
            

            $result['data'][] = [
                'Key' => $item->Key,
                'No' => $item->No,
                'Title' => !empty($item->Title)?$item->Title:'Not Set',
                'Supplier_Category' => !empty($item->Supplier_Category)?$item->Supplier_Category:'Not Set ',
                'Tender_Opening_Date' => !empty($item->Tender_Opening_Date)?$item->Tender_Opening_Date:'',
                'Status' => !empty($item->Status)?$item->Status:'',
                'Actions' => $downloadLink ,

            ];
        }

        return $result;
    }


    public function actionDownload(){
        if(Yii::$app->user->isGuest){
            $this->layout = 'external';
        }
        $base = basename(Yii::$app->request->post('path'));
        /* $ctx = Yii::$app->recruitment->connectWithAppOnlyToken(
             Yii::$app->params['sharepointUrl'],
             Yii::$app->params['clientID'],
             Yii::$app->params['clientSecret']
         );*/


       /* $ctx = Yii::$app->recruitment->connectWithUserCredentials(Yii::$app->params['sharepointUrl'],Yii::$app->params['sharepointUsername'],Yii::$app->params['sharepointPassword']);
        $fileUrl = '/'.Yii::$app->params['library'].'/'.$base;
        $targetFilePath = './qualifications/download.pdf';
        $resource = Yii::$app->recruitment->downloadFile($ctx,$fileUrl,$targetFilePath);*/


       // $path = Yii::getAlias('@frontend').'\\web\\qualifications\\'.$base;
        $path =  str_replace('/', '\\', Yii::$app->request->post('path')); // Normalize the damn path
        $resource = base64_encode(file_get_contents($path));
		//\Yii::$app->recruitment->printrr($resource);
        return $this->render('read',[
            'content' => $resource
        ]);


    }

    public function actionRead()
    {
        $model = new Attachment();
        $fileKey = Yii::$app->request->post('Key');

        $content = $model->readAttachment($fileKey);

        // Yii::$app->recruitment->printrr($content);

        return $this->render('readDocument',[
            'content' => $content
        ]);
    }

}
