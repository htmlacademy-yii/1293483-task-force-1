<?php
use yii\helpers\Url;
use htmlacademy\data\FormatDate;
?>
<section class="content-view">
    <div class="content-view__card">
        <div class="content-view__card-wrapper">
            <div class="content-view__header">
                <div class="content-view__headline">
                    <h1><?= $task->title ?></h1>
                    <span>Размещено в категории
                        <a href="#" class="link-regular"><?= $task->category->name ?></a>
                        <?= Yii::$app->formatter->asRelativeTime($task->dt_add) ?></span>
                </div>
                <b class="new-task__price new-task__price--<?= $task->category->icon ?> content-view-price"><?= $task->budget ?><b> ₽</b></b>
                <div class="new-task__icon new-task__icon--<?= $task->category->icon ?> content-view-icon"></div>
            </div>
            <div class="content-view__description">
                <h3 class="content-view__h3">Общее описание</h3>
                <p>
                    <?= $task->description ?>
                </p>
            </div>
            <?php if (count($task->files)) :  ?>
                <div class="content-view__attach">
                    <h3 class="content-view__h3">Вложения</h3>
                    <a href="#">my_picture.jpeg</a>
                    <a href="#">agreement.docx</a>
                </div>
            <?php endif; ?>
            <div class="content-view__location">
                <h3 class="content-view__h3">Расположение</h3>
                <div class="content-view__location-wrapper">
                    <div class="content-view__map">
                        <a href="#"><img src="../img/map.jpg" width="361" height="292"
                                         alt="Москва, Новый арбат, 23 к. 1"></a>
                    </div>
                    <div class="content-view__address">
                        <span class="address__town"><?= $task->city->name ?></span><br>
                        <span><?= $task->address ?></span>
                        <p>Вход под арку, код домофона 1122</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-view__action-buttons">
            <button class=" button button__big-color response-button open-modal"
                    type="button" data-for="response-form">Откликнуться</button>
            <button class="button button__big-color refusal-button open-modal"
                    type="button" data-for="refuse-form">Отказаться</button>
            <button class="button button__big-color request-button open-modal"
                    type="button" data-for="complete-form">Завершить</button>
        </div>
    </div>
    <div class="content-view__feedback">
        <?php if (count($task->replies)) : ?>
            <h2>Отклики <span>(<?= count($task->replies) ?>)</span></h2>
            <div class="content-view__feedback-wrapper">
                <?php foreach ($task->replies as $reply) : ?>
                    <div class="content-view__feedback-card">
                        <div class="feedback-card__top">
                            <a href="<?= Url::to(['users/view', 'id' => $reply->user->id]) ?>"><img src="<?= $reply->user->avatar ?? '../img/no-avatar.svg' ?>" width="55" height="55"></a>
                            <div class="feedback-card__top--name">
                                <p><a href="<?= Url::to(['users/view', 'id' => $reply->user->id]) ?>" class="link-regular"><?= $reply->user->name ?></a></p>
                                <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                                <b><?= $reply->user->rating ?? 0 ?></b>
                            </div>
                            <span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($reply->dt_add) ?></span>
                        </div>
                        <div class="feedback-card__content">
                            <p>
                                <?= $reply->content ?>
                            </p>
                            <span><?= $reply->price ?> ₽</span>
                        </div>
                        <div class="feedback-card__actions">
                            <a class="button__small-color request-button button"
                               type="button">Подтвердить</a>
                            <a class="button__small-color refusal-button button"
                               type="button">Отказать</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<section class="connect-desk">
    <div class="connect-desk__profile-mini">
        <div class="profile-mini__wrapper">
            <h3>Заказчик</h3>
            <div class="profile-mini__top">
                <img src="<?= $task->customer->avatar ?? '../img/no-avatar.svg' ?>" width="62" height="62" alt="Аватар заказчика">
                <div class="profile-mini__name five-stars__rate">
                    <p><?= $task->customer->name ?></p>
                </div>
            </div>
            <p class="info-customer">
                <span><?= Yii::$app->i18n->format('{n, plural, =0{нет заданий} one{# задание} many{# заданий} other{# задания}}', ['n' => $task->customer->customerTasksCount], 'ru_RU') ?></span>
                <span class="last-"><?= FormatDate::formatDateAsDuration($task->customer->dt_add) ?> на сайте</span>
            </p>
            <a href="<?= Url::to(['users/view', 'id' => $task->customer->id]) ?>" class="link-regular">Смотреть профиль</a>
        </div>
    </div>
    <div class="connect-desk__chat">
        <h3>Переписка</h3>
        <div class="chat__overflow">
            <div class="chat__message chat__message--out">
                <p class="chat__message-time">10.05.2019, 14:56</p>
                <p class="chat__message-text">Привет. Во сколько сможешь
                    приступить к работе?</p>
            </div>
            <div class="chat__message chat__message--in">
                <p class="chat__message-time">10.05.2019, 14:57</p>
                <p class="chat__message-text">На задание
                    выделены всего сутки, так что через час</p>
            </div>
            <div class="chat__message chat__message--out">
                <p class="chat__message-time">10.05.2019, 14:57</p>
                <p class="chat__message-text">Хорошо. Думаю, мы справимся</p>
            </div>
        </div>
        <p class="chat__your-message">Ваше сообщение</p>
        <form class="chat__form">
            <textarea class="input textarea textarea-chat" rows="2" name="message-text" placeholder="Текст сообщения"></textarea>
            <button class="button chat__button" type="submit">Отправить</button>
        </form>
    </div>
</section>
