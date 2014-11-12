<?php

use app\models\Page;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use app\backend\widgets\BackendWidget;
use vova07\imperavi\Widget as ImperaviWidget;
use app\backend\widgets\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\DateTimePicker;
use kartik\icons\Icon;

$this->title = Yii::t('app', 'View edit');
$this->params['breadcrumbs'][] = ['url' => [Url::toRoute('index')], 'label' => Yii::t('app', 'Views')];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= app\widgets\Alert::widget([
    'id' => 'alert',
]); ?>

<?php $form = ActiveForm::begin(['id' => 'view-form', 'type'=>ActiveForm::TYPE_HORIZONTAL]); ?>

<?php $this->beginBlock('submit'); ?>
<div class="form-group no-margin">
    <?=
    Html::submitButton(
        Icon::show('save') . Yii::t('app', 'Save'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    ) ?>
</div>
<?php $this->endBlock('submit'); ?>

<section id="widget-grid">
    <div class="row">
        
        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

            <?php BackendWidget::begin(['title'=> Yii::t('app', 'Common'), 'icon'=>'pencil', 'footer'=>$this->blocks['submit']]); ?>

                <?= $form->field($model, 'name'); ?>
                <?= $form->field($model, 'view', [
                    'addon' => [
                        'append' => [
                            'content' => Html::button(
                                Icon::show('folder-open-o'),
                                ['class'=>'btn btn-primary', 'id'=>'show-tree']
                            ),
                            'asButton' => true,
                        ]
                    ]
                ]); ?>
                <?= $form->field($model, 'category'); ?>
                <?= $form->field($model, 'internal_name'); ?>

            <?php BackendWidget::end(); ?>

        </article>

        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        </article>

    </div>
</section>

<?php ActiveForm::end(); ?>

<div class="modal fade" id="modal-jstree" tabindex="-1" role="dialog" aria-labelledby="jstree-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><?= Yii::t('app', 'Tree of templates') ?></h4>
            </div>
            <div class="modal-body">
                <div id="jstree"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Cancel') ?></button>
                <button type="button" class="btn btn-success" id="modal-apply">Yii::t('app', 'Choose')</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('#show-tree').on('click', function(){
                $('#jstree').jstree({
                    'plugins': ['wholerow', 'types'],
                    'core': {
                        'check_callback': true,
                        'data': {
                            'url': function (node) {
                                return '<?= Url::toRoute('get-views');?>';
                            },
                            'data': function (node) {
                                return {'id': node.id};
                            }
                        }
                    },
                    'types': {
                        'dir': {'icon': 'fa fa-folder-open-o'},
                        'file': {'icon': 'fa fa-folder-file-o'}
                    }
                });
            $('#modal-jstree').modal('show');
        });

        $('#modal-apply').on('click', function(){
            var sel = $('#jstree').jstree(true).get_selected(true);
            if (typeof sel[0].a_attr['data-file'] !== 'undefined') {
                $('#view-view').val(sel[0].a_attr['data-file']);
                $('#modal-jstree').modal('hide');
            }
        });
    });
</script>