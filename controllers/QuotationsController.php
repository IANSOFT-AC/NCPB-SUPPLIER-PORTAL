<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace app\controllers;



use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use yii\web\Response;
use kartik\mpdf\Pdf;

use app\models\Vendorquote;

class QuotationsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup','index','list','create','update','delete','view','supervisorlist','hrlist','extrasupervisorlist','closedlist'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'logout',
                            'index',
                            'list',
                            'create',
                            'update',
                            'delete',
                            'view',
                            'supervisorlist',
                            'hrlist',
                            'extrasupervisorlist',
                            'closedlist',
                            'gsappraiseelist',
                            'gssuperlist',
                            'gshrlist',
                            'myappraiseelist',
                            'mysuperlist',
                            'myhrlist'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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

    public function actionIndex(){

        return $this->render('index');

    }

   


    public function actionAwarded(){

        return $this->render('awarded');

    }

    public function actionCreate(){

       
        $service = Yii::$app->params['ServiceName']['AppraisalCard'];

        $data = ['Employee_No' => Yii::$app->user->identity->{'Employee No_'}];

        $result =  Yii::$app->navhelper->postData($service,$data);

        if(is_object($result))
        {
            return $this->redirect(['view','No' => $result->Appraisal_Code]);
        }else if(is_string($result)){
            Yii::$app->setFlash('Error', $result);
             return $this->redirect(['index']);
        }

        return $this->render('create',[
            'model' => $model,
            'safariRequests' => $this->safariRequests(),
            'functions' => $this->getFunctioncodes(),
            'budgetCenters' => $this->getBudgetcenters()
           
        ]);
    }




    public function actionUpdate(){
        $model = new Vendorquote();
        $service = Yii::$app->params['ServiceName']['VendorQuote'];
        $model->isNewRecord = false;

        if(Yii::$app->request->post('Key') )
        {
             $result = Yii::$app->navhelper->readByKey($service, Yii::$app->request->post('Key'));

            // Yii::$app->recruitment->printrr($result);

            if(!is_string($result)){
                //load nav result to model
                $model = Yii::$app->navhelper->loadmodel($result,$model) ;//$this->loadtomodeEmployee_Nol($result[0],$Expmodel);
            }else{
                 Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            

                return ['note' => '<div class="alert alert-danger">Error</div>'];
            

            }
        }
       


        if(Yii::$app->request->post() && !Yii::$app->request->post('Key') && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Vendorquote'],$model) ){
            

            //Yii::$app->recruitment->printrr($model);
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->readByKey($service, $model->Key);
            $model->Key = $refresh->Key;



            $result = Yii::$app->navhelper->updateData($service,$model);

           // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
            if(!is_string($result)){

                 Yii::$app->session->setFlash('success','Quote Submitted Successfully.');
                return $this->redirect(['index']);

            }else{
                Yii::$app->session->setFlash('error',$result);
                return $this->redirect(['index']);

            }

        }


        // Yii::$app->recruitment->printrr($model);
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model
                
            ]);
        }

        return $this->render('update',[
            'model' => $model

        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['MileageCard'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){

            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionView($No){
        // Yii::$app->recruitment->printrr(Yii::$app->user->identity->{'User ID'});
		$model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['AppraisalCard'];

        $result = Yii::$app->navhelper->findOne($service, 'Appraisal_Code', $No);


        //load nav result to model
        $model = $this->loadtomodel($result, $model);

        return $this->render('view',[
            'model' => $model,
        ]);
    }



    public function actionList(){

        $service = Yii::$app->params['ServiceName']['VendorQuote'];
        $filter = [
            //'Vendor_No' => Yii::$app->user->identity->vendor->Generated_Vendor_No,
        ];
        
        $results = \Yii::$app->navhelper->getData($service,$filter);
        // Yii::$app->recruitment->printrr($results);
        $result = [];
        foreach($results as $item){

            if(empty($item->Item_No))
            {
                continue;
            }


            $ApprovalLink = $updateLink = $ViewLink =  '';
            // $ViewLink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->Appraisal_Code ],['title' => 'View Appriasal Card..','class'=>'btn btn-outline-primary btn-xs']);
            $updateLink = Html::a('<i class="fas fa-pen"></i> Quote ',['update'],[
                'title' => 'Fill in Quote.',
                'class'=>'btn update btn-outline-primary btn-xs',
                'data' => [
                    'method' => 'POST',
                    'params' => [
                        'Key'=> $item->Key
                    ],
                ]
            ]);
            

            $result['data'][] = [
                'Key' => $item->Key,
                'No' => $item->Vendor_No,
                'Vendor_Name' => !empty($item->Vendor_Name)?$item->Vendor_Name:'',
                'Item' => !empty($item->Item_Name)?$item->Item_Name:'',
                'Quantity' => !empty($item->Quantity)?$item->Quantity:'',
                'Description' => !empty($Description)?$Description:'',
                'Quoted_Amount' => !empty($item->Quoted_Amount)?$item->Quoted_Amount:'',
                'VAT_Inclusive' => Html::checkbox('VAT_Inclusive',$item->VAT_Inclusive),
                'VAT_Amount' => !empty($item->VAT_Amount)?$item->VAT_Amount:'',
                'Lead_Time' => !empty($item->Lead_Time)?$item->Lead_Time:'',
                'Status' => !empty($item->Status)?$item->Status:'',
                'Actions' => $updateLink ,

            ];
        }

        return $result;
    }


   

   
    


    /*Appraisal Report Codeunit fxn*/


    public function actionReport()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
       
        $data = [
            'appraisalNo' => Yii::$app->request->post('appraisalNo'),
            'employeeNo' => Yii::$app->request->post('employeeNo')
            
        ];


         $path = Yii::$app->navhelper->codeunit($service,$data,'IanAppraisalSummaryPrintOut');

         if(!isset($path['return_value']) || !is_file($path['return_value'])){

                return $this->render('report',[
                    'report' => false,
                    'message' => isset($path['return_value'])?$path['return_value']:'Report is not available',
                ]);
        }

        // Report is available
        $binary = file_get_contents($path['return_value']); //fopen($path['return_value'],'rb');
        $content = chunk_split(base64_encode($binary));

        @unlink($path['return_value']);

        return $this->render('report',[
                'report' => true,
                'content' => $content,
            ]);
    }


     


    public function actionSetfield($field){
        $service = 'MileageCard';
        $value = Yii::$app->request->post($field);
        $filterValue =Yii::$app->request->post('No'); 
        $filterKey = 'Claim_No';

        $result = Yii::$app->navhelper->Commit($service,$field,$value,$filterKey,$filterValue);
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;
        
    }



}