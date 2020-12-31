<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\TasksFilterForm;
use yii\widgets\LinkPager;

$this->title = 'Новые задания';
?>
<section class="new-task">
    <div class="new-task__wrapper">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php foreach ($dataProvider->getModels() as $task) : ?>
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="#" class="link-regular"><h2><?= $task->title ?></h2></a>
                    <a  class="new-task__type link-regular" href="#"><p><?= $task->category->name ?></p></a>
                </div>
                <div class="new-task__icon new-task__icon--<?= $task->category->icon ?>"></div>
                <p class="new-task_description">
                    <?= $task->description ?>
                </p>
                <b class="new-task__price new-task__price--translation"><?= $task->budget ?><b> ₽</b></b>
                <p class="new-task__place"><?= $task->address ?></p>
                <span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($task->dt_add) ?></span>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="new-task__pagination">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
            'prevPageLabel' => '',
            'nextPageLabel' => '',
            'options' => [
                'class' => 'new-task__pagination-list',
            ],
            'linkContainerOptions' => ['class' => 'pagination__item'],
            'activePageCssClass' => 'pagination__item--current',

        ]) ?>
    </div>
</section>
<section  class="search-task">
    <div class="search-task__wrapper">
        <?php $form = ActiveForm::begin([
            'id' => 'tasks-form',
            'method' => 'get',
            'action' => [''],
            'options' => [
                'class' => 'search-task__form',
                'name' => 'test',
            ],
            'fieldConfig' => [
                'options' => [
                    'tag' => false,
                ],
            ],
        ]); ?>
            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <?= $form->field($model, 'categories')
                    ->label(false)
                    ->checkboxList(ArrayHelper::map(TasksFilterForm::getCategories(), 'id', 'name'), [
                        'unselect' => null,
                        'item' =>
                            function($index, $label, $name, $checked, $value) {
                                return Html::checkbox($name, $checked, [
                                    'class' => 'visually-hidden checkbox__input',
                                    'name' => $name,
                                    'value' => $value,
                                    'id' => $value,
                                ]) . Html::label($label, $value);
                            }
                    ]) ?>
            </fieldset>
            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <?= $form->field($model, 'noReply', ['template' => "{input}\n{label}"])
                    ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false) ?>
                <?= $form->field($model, 'remoteWork', ['template' => "{input}\n{label}"])
                    ->checkbox(['class' => 'visually-hidden  checkbox__input', 'uncheck' => null], false) ?>
            </fieldset>
            <?= $form->field($model, 'period', ['template' => "{label}\n{input}"])
                ->dropDownList(TasksFilterForm::getPeriod(), ['class' => 'multiple-select input', 'prompt' =>'За всё время',])
                ->label(null, ['class' => 'search-task__name']) ?>
            <?= $form->field($model, 'search', ['template' => "{label}\n{input}"])
                ->textInput(['unselect' => null, 'class' => 'input-middle input'])
                ->label(null, ['class' => 'search-task__name']) ?>
            <?= Html::submitButton('Искать', ['class' => 'button']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>
