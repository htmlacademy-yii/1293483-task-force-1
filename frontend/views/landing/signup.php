<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\SignupForm;

$this->title = 'Регистрация аккаунта';
?>
<section class="registration__user">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="registration-wrapper">
        <?php $form = ActiveForm::begin([
            'id' => 'signup-form',
            'options' => [
                'class' => 'registration__user-form form-create',
            ],
            'fieldConfig' => [
                'options' => [
                    'style' => 'display: flex; flex-direction: column;',
                ],
            ],
        ]); ?>
        <?= $form->field($model, 'email', ['errorOptions' => ['tag' => 'span', 'style' => 'margin-bottom: 29px;']])
            ->textInput(['class' => 'input textarea', 'rows' => 1])
            ->label(null, ['class' => $model->hasErrors('email') ? 'input-danger' : '', 'style' => 'margin-top: 0;']) ?>
        <?= $form->field($model, 'name', ['errorOptions' => ['tag' => 'span', 'style' => 'margin-bottom: 29px;']])
            ->textInput(['class' => 'input textarea', 'rows' => 1])
            ->label(null, ['class' => $model->hasErrors('name') ? 'input-danger' : '']) ?>
        <?= $form->field($model, 'cityId', ['errorOptions' => ['tag' => 'span', 'style' => 'margin-bottom: 29px;']])
            ->dropDownList(ArrayHelper::map($cities, 'id', 'name'), ['class' => 'multiple-select input town-select registration-town'])
            ->label(null, ['class' => $model->hasErrors('cityId') ? 'input-danger' : ''])?>
        <?= $form->field($model, 'password', ['errorOptions' => ['tag' => 'span', 'style' => 'margin-bottom: 29px;']])
            ->passwordInput(['class' => 'input textarea'])
            ->label(null, ['class' => $model->hasErrors('password') ? 'input-danger' : '']) ?>
        <?= Html::submitButton('Cоздать аккаунт', ['class' => 'button button__registration']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>
