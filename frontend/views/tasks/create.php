<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$this->title = 'Публикация нового задания';
?>
<section class="create__task">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="create__task-main">
        <?php $form = ActiveForm::begin([
            'id' => 'create-task-form',
            'enableClientValidation' => false,
            'options' => [
                'class' => 'create__task-form form-create',
                'enctype' => 'multipart/form-data',
            ],
            'fieldConfig' => [
                'options' => [
                    'tag' => false,
                ],
            ],
        ]); ?>
        <?= $form->field($model, 'title', ['errorOptions' => ['tag' => 'span']])
            ->textInput(['class' => 'input textarea', 'rows' => 1, 'placeholder' => 'Повесить полку'])
            ->label(null, ['class' => $model->hasErrors('title') ? 'input-danger' : ''])
            ->hint($model->hasErrors('title') ? '' : 'Кратко опишите суть работы', ['tag' =>'span', 'style' =>'margin-top: 0px']) ?>
        <?= $form->field($model, 'description', ['errorOptions' => ['tag' => 'span']])
            ->textarea(['class' => 'input textarea', 'rows' => 7])
            ->label(null, ['class' => $model->hasErrors('description') ? 'input-danger' : ''])
            ->hint($model->hasErrors('description') ? '' : 'Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться', ['tag' =>'span', 'style' =>'margin-top: 0px']) ?>
        <?= $form->field($model, 'categoryId', ['errorOptions' => ['tag' => 'span']])
            ->dropDownList(ArrayHelper::map($categories, 'id', 'name'), ['class' => 'multiple-select input multiple-select-big'])
            ->label(null, ['class' => $model->hasErrors('categoryId') ? 'input-danger' : ''])
            ->hint($model->hasErrors('categoryId') ? '' : 'Выберите категорию', ['tag' =>'span', 'style' =>'margin-top: 0px']) ?>
        <label>Файлы</label>
        <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
        <?= $form->field($model, 'files[]', ['options' => ['tag' => 'div', 'class' => 'create__file'], 'template' => "<span>Добавить новый файл</span>"])
            ->fileInput(['multiple' => true, 'accept' => 'image/*', 'class' => 'dropzone'])
            ->hint('Добавить новый файл', ['tag' =>'span', 'style' =>'margin-top: 0px'])?>
        <label for="13">Локация</label>
        <input class="input-navigation input-middle input" id="13" type="search" name="q" placeholder="Санкт-Петербург, Калининский район">
        <span>Укажите адрес исполнения, если задание требует присутствия</span>
        <div class="create__price-time">
            <?= $form->field($model, 'budget', ['errorOptions' => ['tag' => 'span'], 'options' => ['tag' => 'div', 'class' => 'create__price-time--wrapper']])
                ->textInput(['class' => 'input textarea input-money', 'placeholder' => '1000'])
                ->label(null, ['class' => $model->hasErrors('budget') ? 'input-danger' : ''])
                ->hint($model->hasErrors('budget') ? '' : 'Не заполняйте для оценки исполнителем', ['tag' =>'span', 'style' =>'margin-top: 0px']) ?>
            <?= $form->field($model, 'dtEnd', ['errorOptions' => ['tag' => 'span'], 'options' => ['tag' => 'div', 'class' => 'create__price-time--wrapper']])
                ->textInput(['class' => 'input-middle input input-date', 'type' => 'date'])
                ->label(null, ['class' => $model->hasErrors('dtEnd') ? 'input-danger' : ''])
                ->hint($model->hasErrors('dtEnd') ? '' : 'Укажите крайний срок исполнения', ['tag' =>'span', 'style' =>'margin-top: 0px']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="create__warnings">
            <div class="warning-item warning-item--advice">
                <h2>Правила хорошего описания</h2>
                <h3>Подробности</h3>
                <p>Друзья, не используйте случайный<br>
                    контент – ни наш, ни чей-либо еще. Заполняйте свои
                    макеты, вайрфреймы, мокапы и прототипы реальным
                    содержимым.</p>
                <h3>Файлы</h3>
                <p>Если загружаете фотографии объекта, то убедитесь,
                    что всё в фокусе, а фото показывает объект со всех
                    ракурсов.</p>
            </div>
            <?php if ($model->hasErrors()) : ?>
                <?php $labels = $model->attributeLabels() ?>
                <div class="warning-item warning-item--error">
                    <h2>Ошибки заполнения формы</h2>
                    <?php foreach ($model->firstErrors as $key => $error) : ?>
                        <h3><?= $labels[$key] ?></h3>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?= Html::submitButton('Опубликовать', ['class' => 'button', 'form' => 'create-task-form']) ?>
</section>
