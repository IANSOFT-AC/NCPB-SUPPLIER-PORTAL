<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/23/2020
 * Time: 4:29 PM
 */

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::$app->params['generalTitle'].' - Document Uploads';
?>

  




    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Supplier Document Uploads</h3>

                </div>
                <div class="card-body" >



                    <?php if(is_array($uploads)): $counter = 0;    ?>
                        <table class="table table-bordered" id="documents">
                        <?php foreach($uploads as $upload){

                           

                            $counter++;
                            echo '<tr>
                                <td>'.$counter.'</td>
                                <td>'.$upload->Name.'</td>
                                <td>'.(($model->getAttachment($upload->Name, Yii::$app->user->identity->VendorId))
                                ?Html::a('<i class="fa fa-eye mx-1"></i> View',['read'],[
                                    'class' => 'btn btn-outline-warning',
                                    'data' => [
                                            'params' => [
                                                'Key' => $model->getAttachment($upload->Name, Yii::$app->user->identity->VendorId)->Key
                                            ],
                                            'method' => 'post'
                                        ]
                                    ])
                                :'Not Yet Uploaded').'</td>
                                <td>'.((!$model->getAttachment($upload->Name, Yii::$app->user->identity->VendorId))?Html::a('<i class="fa fa-upload mx-1"></i> Upload',['attach','NAME' => $upload->Name],[
                                    'class' => 'attach btn btn-outline-warning']):

                                    Html::a('<i class="fa fa-upload mx-1"></i> Update',['attach',
                                                'NAME' => $upload->Name,
                                                'Key' => $model->getAttachment($upload->Name, Yii::$app->user->identity->VendorId)->Key
                                            ],
                                            [
                                                'class' => 'attach btn btn-success'
                                            ])
                                     ).'</td>
                            </tr>';

                        }

                         ?>
                        </table>

                    <?php else: ?>

                        <p class="lead">No files required for upload.</p>

                    <?php endif; ?>

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
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Supplier Document Manager</h4>
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

  <?php
  
  $script = <<<JS
       $('#documents').on('click','.attach', function(e){
                 e.preventDefault();
                var url = $(this).attr('href');
                console.log('clicking...');
                $('.modal').modal('show')
                                .find('.modal-body')
                                .load(url); 
    
            });


         /*Handle dismissal eveent of modal */
         $('.modal').on('hidden.bs.modal',function(){
            var reld = location.reload(true);
            setTimeout(reld,1000);
        });
  JS;

  $this->registerJs($script);


   







