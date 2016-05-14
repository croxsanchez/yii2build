<?php
/**
 * @var Customer $model
 */
use backend\models\customer\Customer;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

echo DetailView::widget(
    [
        'model' => $model,
        'attributes' => [
            ['attribute' => 'name'],
            ['attribute' => 'birth_date', 'value' => $model->birth_date->format('Y-m-d')],
            'notes:text', 'customer_type_id',
            ['label' => 'Phone Number', 'attribute' => 'phones.0.number']
        ]
    ]);
