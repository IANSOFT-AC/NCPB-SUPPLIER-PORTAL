<?php
namespace app\library;
use yii;
use yii\base\Component;
use app\models\Services;
use yii\web\Response;
//http://app-svr.rbss.com:7047/BC130/WS/RBA UAT/Page/Recruitment_Needs
class Navhelper extends Component{
    //read data-> pass filters as get params
    public function getData($service,$params=[]){
        # return true; //comment after dev or after testing outside Navision scope env
        $identity = \Yii::$app->user->identity;
        $username =  Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;

        $url = new Services($service);

        $soapWsdl= $url->getUrl();
        //Yii::$app->recruitment->printrr($soapWsdl);

        $filter = [];
        if(sizeof($params)){
            foreach($params as $key => $value){
                $filter[] = ['Field' => $key, 'Criteria' =>$value];
            }
        }


        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }
        //add the filter
        $results = Yii::$app->navision->readEntries($creds, $soapWsdl,$filter);


        //return array of object
        if(is_object($results->ReadMultiple_Result) && property_exists($results->ReadMultiple_Result, $service)){
            $lv =(array)$results->ReadMultiple_Result;
            return $lv[$service];
        }else{
            return $results;
        }

    }

    public function findOne($service,$filterKey, $filterValue){

        $url  =  new Services($service);
        $wsdl = $url->getUrl();
        $username =  Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;

        if(!Yii::$app->navision->isUp($wsdl,$creds)) {

            return ['error' => 'Service unavailable.'];

        }


        $res = (array)$result = Yii::$app->navision->readEntry($creds, $wsdl, $filterKey, $filterValue);

        if(count($res)){
            return $res[$service];
        }else{
            return false;
        }
        
    }


    /*Read a single Record By Key*/


    public function readByKey($service,$Key){

        $url  =  new Services($service);
        $wsdl = $url->getUrl();
        $username = Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;

        if(!Yii::$app->navision->isUp($wsdl,$creds)) {

            return ['error' => 'Service unavailable.'];

        }


        $res = (array)$result = Yii::$app->navision->readByRecID($creds, $wsdl, $Key);

        if(count($res)){
            return $res[$service];
        }else{
            return false;
        }
        
    }

    //create record(s)-----> post data
    public function postData($service,$data){
        $identity = \Yii::$app->user->identity;
        $username =  Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->params['NavisionPassword'];
        $post = Yii::$app->request->post();

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];
        $entryID = $service;
        foreach($data as $key => $value){
            if($key !=='_csrf-backend'){
                $entry->$key = $value;
            }

        }
//exit('lll');
        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        // $results = Yii::$app->navision->readEntries($creds, $soapWsdl,$filter);
        $results = Yii::$app->navision->addEntry($creds, $soapWsdl,$entry, $entryID);

        if(is_object($results)){
            $lv =(array)$results;

            return $lv[$service];
        }
        else{
            return $results;
        }

        /*print '<pre>'; print_r($results); exit;
        $lv =(array)$results;

        return $lv[$service];*/
    }
    //update data   -->post data
    public function updateData($service,$data, $exception = []){
        $identity = \Yii::$app->user->identity;
        $username =  Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->params['NavisionPassword'];
        $post = Yii::$app->request->post();

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];
        $entryID = $service;
        foreach($data as $key => $value){
            if($key !=='_csrf-frontend' && !in_array($key, $exception, TRUE)){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }

        // $results = Yii::$app->navision->readEntries($creds, $soapWsdl,$filter);
        $results = Yii::$app->navision->updateEntry($creds, $soapWsdl,$entry, $entryID);
        //add the filter so you don't display all loans to all and sundry.... just logic!!!
        if(is_object($results)){
            $lv =(array)$results;

            return $lv[$service];
        }
        else{
            return $results;
        }
    }
    //purge data --> pass key as get param
    public function deleteData($service,$key){
        $identity = \Yii::$app->user->identity;
        $username =  Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->params['NavisionPassword'];
        $url = new Services($service);
        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $soapWsdl = $url->getUrl();
        $result = Yii::$app->navision->deleteEntry($creds, $soapWsdl, $key);
        //just return the damn object
        return $result;

    }




     //General Code unit invocation implementation method

     public function Codeunit($service,$data,$method){
        $identity = \Yii::$app->user->identity;
        $username =  Yii::$app->params['NavisionUsername'];
        $password = Yii::$app->params['NavisionPassword'];

        $creds = (object)[];
        $creds->UserName = $username;
        $creds->PassWord = $password;
        $url = new Services($service);
        $soapWsdl=$url->getUrl();

        $entry = (object)[];

        foreach($data as $key => $value){
            if($key !=='_csrf-frontend'){
                $entry->$key = $value;
            }

        }

        if(!Yii::$app->navision->isUp($soapWsdl,$creds)) {
            throw new \yii\web\HttpException(503, 'Service unavailable');

        }


        $results = Yii::$app->navision->Codeunit($creds, $soapWsdl,$entry,$method);

        if(is_object($results)){
            $lv =(array)$results;
            return $lv;
        }
        else{
            return $results;
        }

    }



    /*Method to commit single field data to services*/

    public function Commit($service,$field=[],$filter=[]){
       
        $commitService = $service;

        if(sizeof($field)){
            foreach($field as $key => $value){
                $fieldName = $key;
                $fieldValue = $value;
            }
        }

        $service = Yii::$app->params['ServiceName'][$commitService];

        if(sizeof($filter)){
            foreach($filter as $key => $value){
                $filter[] = ['Field' => $key, 'Criteria' =>$value];
            }
        }

        $request = Yii::$app->navhelper->getData($service, $filter);


        $data = [];
        if(is_array($request)){
            $data = [
                'Key' => $request[0]->Key,
                $fieldName => $fieldValue
            ];
        }else{
            Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
            return ['error' => $request];
        }



        $result = Yii::$app->navhelper->updateData($service,$data);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }




    /**Auxilliary methods for working with models */

    public function loadmodel($obj,$model){ //load object data to a model, e,g from service data to model

        if(!is_object($obj)){
            return false;
        }
        $modeldata = (get_object_vars($obj)) ;
        foreach($modeldata as $key => $val){
            if(is_object($val)) continue;
            $model->$key = $val;
        }

        return $model;
    }

    public function loadpost($post,$model){ // load form data to a model, e.g from html form-data to model


        $modeldata = (get_object_vars($model)) ;

        foreach($post as $key => $val){

            $model->$key = $val;
        }

        return $model;
    }

   


    /*
     * Custom functions defined to interact with ERP Code unit functions 
     *  
     * */

  
      // Refactor an array with valid and existing data

    public function refactorArray($arr,$from,$to)
    {
        $list = [];
        if(is_array($arr))
        {

            foreach($arr as $item)
            {
                if(!empty($item->$from) && !empty($item->$to))
                {
                    $list[] = [
                        $from => $item->$from,
                        $to => $item->$to
                    ];
                }

            }

            return  yii\helpers\ArrayHelper::map($list, $from, $to);

        }

        return $list;
    }
}


?>