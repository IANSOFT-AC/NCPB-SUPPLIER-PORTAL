<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/10/2020
 * Time: 2:27 PM
 */

namespace app\library;
use common\models\Poll;
use yii;
use yii\base\Component;
use app\models\Hruser;


class Dashboard extends Component
{

    public function getStaffCount(){
        return 0;
        $service = Yii::$app->params['ServiceName']['employees'];
        $filter = [];
        $result = Yii::$app->navhelper->getData($service,$filter);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result fails
            return false;
        }
        return count($result);
    }

    /*My Rejected Approval Requests*/

    public function getRejectedApprovals(){
        return 0;
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Sender_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Rejected'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter results to false
            return 0;
        }
        return count($result);
    }

    /* My Approved Requests */

    public function getApprovedApprovals(){
        return 0;
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Sender_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Approved'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

    /* Get Pending Approvals */

    public function getOpenApprovals(){
        return 0;
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Sender_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Open'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }



    /*Request I have approved*/

    public function getSuperApproved(){
        return 0;
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Approver_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Approved'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }


    /* Requests I have Rejected */

    public function getSuperRejected(){
        return 0;
        $service = Yii::$app->params['ServiceName']['RequeststoApprove'];
        $filter = [
            'Approver_ID' => Yii::$app->user->identity->getId(),
            'Status' => 'Rejected'
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }


    /*Get Number of job vacancies available*/

    public function getVacancies(){
        return 0;
        $service = Yii::$app->params['ServiceName']['JobsList'];
        $filter = [
            'No_of_Posts' => '>0',
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

    /*Get Staff on Leave*/

    public function getOnLeave(){
        return 0;
        $service = Yii::$app->params['ServiceName']['activeLeaveList'];
        $filter = [];
        $result = Yii::$app->navhelper->getData($service,$filter);

        //Yii::$app->recruitment->printrr($result);
        if(is_object($result) || is_string($result)){//RETURNS AN EMPTY object if the filter result to false
            return 0;
        }
        return count($result);
    }

    public function Getsurveys(){
        return 0;
        $surveys = Poll::find()->count();
        return $surveys;
    }



}