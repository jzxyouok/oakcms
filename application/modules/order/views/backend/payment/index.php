<?php
use yii\helpers\Html;

use app\modules\order\assets\Asset;
Asset::register($this);

$this->title = yii::t('order', 'Payments');

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-2">
            <?= Html::a(Yii::t('order', 'Create payment'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-lg-10">
            <?= $this->render('/parts/menu.php', ['active' => 'payment']); ?>
        </div>
    </div>

    <br />

    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'amount',
            'date',
            [
                'attribute' => 'payment_type_id',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'payment_type_id',
                    $paymentTypes,
                    ['class' => 'form-control', 'prompt' => Yii::t('order', 'Payment type')]
                ),
                'value' => function($model) use ($paymentTypes) {
                    if(isset($paymentTypes[$model->payment_type_id])) {
                        return $paymentTypes[$model->payment_type_id];
                    }
                }
            ],
            'ip',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
