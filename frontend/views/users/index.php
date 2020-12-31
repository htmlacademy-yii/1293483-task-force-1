<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use frontend\models\UsersFilterForm;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Исполнители';
?>
<section class="user__search">
    <div class="user__search-link">
        <p>Сортировать по:</p>
        <ul class="user__search-list">
            <li class="user__search-item <?= Yii::$app->request->get('sort') === 'rating' ? 'user__search-item--current' : '' ?>">
                <a href="<?= Url::current(['sort' => 'rating']) ?>" class="link-regular">Рейтингу</a>
            </li>
            <li class="user__search-item <?= Yii::$app->request->get('sort') === 'tasksCount' ? 'user__search-item--current' : '' ?>">
                <a href="<?= Url::current(['sort' => 'tasksCount']) ?>" class="link-regular">Числу заказов</a>
            </li>
            <li class="user__search-item <?= Yii::$app->request->get('sort') === 'popular' ? 'user__search-item--current' : '' ?>">
                <a href="<?= Url::current(['sort' => 'popular']) ?>" class="link-regular">Популярности</a>
            </li>
        </ul>
    </div>
    <?php foreach ($dataProvider->getModels() as $user) : ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="#"><img src="<?= $user->avatar ?? './img/no-avatar.svg' ?>." width="65" height="65"></a>
                    <span><?= Yii::$app->i18n->format('{n, plural, =0{нет заданий} one{# задание} many{# заданий} other{# задания}}', ['n' => $user->tasksCount], 'ru_RU') ?> </span>
                    <span><?= Yii::$app->i18n->format('{n, plural, =0{нет отзывов} one{# отзыв} many{# отзывов} other{# отзыва}}', ['n' => $user->opinionsCount], 'ru_RU') ?></span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name"><a href="#" class="link-regular"><?= $user->name ?></a></p>
                    <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                    <b><?= $user->rating ?? 0 ?></b>
                    <p class="user__search-content">
                        <?= $user->info ?>
                    </p>
                </div>
                <span class="new-task__time">Был на сайте <?= Yii::$app->formatter->asRelativeTime($user->dt_last_visit) ?></span>
            </div>
            <div class="link-specialization user__search-link--bottom">
                <?php foreach ($user->categories as $category) : ?>
                    <a href="#" class="link-regular"><?= $category->name ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
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
                'name' => 'users',
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
                    ->checkboxList(ArrayHelper::map(UsersFilterForm::getCategories(), 'id', 'name'), [
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
                <?= $form->field($model, 'free', ['template' => "{input}\n{label}"])
                    ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => null], false) ?>
                <?= $form->field($model, 'online', ['template' => "{input}\n{label}"])
                    ->checkbox(['class' => 'visually-hidden  checkbox__input', 'uncheck' => null], false) ?>
                <?= $form->field($model, 'hasOpinions', ['template' => "{input}\n{label}"])
                    ->checkbox(['class' => 'visually-hidden  checkbox__input', 'uncheck' => null], false) ?>
                <?= $form->field($model, 'inFavorites', ['template' => "{input}\n{label}"])
                    ->checkbox(['class' => 'visually-hidden  checkbox__input', 'uncheck' => null], false) ?>
            </fieldset>
            <?= $form->field($model, 'search', ['template' => "{label}\n{input}"])
                ->textInput(['class' => 'input-middle input'])
                ->label(null, ['class' => 'search-task__name']) ?>
            <?= Html::submitButton('Искать', ['class' => 'button']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>
