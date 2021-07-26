<?php
/**
 * Lead_Time PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = Yii::$app->params['generalTitle'].' Request for Quatation List';
$this->params['breadcrumbs'][] = ['label' => 'RFQ List', 'url' => ['index']];
$this->params['breadcrumbs'][] = '';
$url = \yii\helpers\Url::home(true);
?>


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






<div class="row">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">My Requests for Quotations List</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered dt-responsive table-hover" id="table">
                </table>
            </div>
            </div>
        </div>
    </div>
</div>



  <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">E-Procurement</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>

            </div>
        </div>
    </div>




    <input type="hidden" value="<?= $url ?>" id="url" />
<?php

$script = <<<JS

    $(function(){
         /*Data Tables*/
         
        $.fn.dataTable.ext.errMode = 'throw';
        const url = $('#url').val();
    
          $('#table').DataTable({
           
            //serverSide: true,  
            ajax: url+'quotations/list',
            paging: true,
            columns: [
                { title: 'No' ,data: 'No'},
                { title: 'Vendor Name' ,data: 'Vendor_Name'},
                { title: 'Item' ,data: 'Item'},
                { title: 'Quantity' ,data: 'Quantity'},
                { title: 'Description' ,data: 'Description'},
                               
                { title: 'Quoted_Amount' ,data: 'Quoted_Amount'},
                { title: 'VAT Inclusive', data: 'VAT_Inclusive' },
                { title: 'VAT Amount', data: 'VAT_Amount' },
                { title: 'Lead Time', data: 'Lead_Time' },
                { title: 'Status', data: 'Status' },
                { title: 'Actions', data: 'Actions' },
               
            ] ,                              
           language: {
                "zeroRecords": "No Records to display"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#table').DataTable();
     // table.columns([8,9]).visible(false);



    
    /*End Data tables*/
        $('#table tbody').on('click',' a.update', function(e){
               /* e.preventDefault();
                var url = $(this).attr('href');
                console.log(url);
                $('.modal').modal('show')
                                .find('.modal-body')
                                .load(url); */

                              

            



        });
    });
        
JS;

$this->registerJs($script);

$style = <<<CSS
    table td:nth-child(7), td:nth-child(8), td:nth-child(9) {
        text-align: center;
    }
CSS;

$this->registerCss($style);







