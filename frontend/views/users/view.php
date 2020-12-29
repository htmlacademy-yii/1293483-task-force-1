<?php
use htmlacademy\data\FormatDate;
?>
<section class="content-view">
    <div class="user__card-wrapper">
        <div class="user__card">
            <img src="<?= $user->avatar ?? '../img/no-avatar.svg' ?>" width="120" height="120" alt="Аватар пользователя">
            <div class="content-view__headline">
                <h1><?= $user->name ?></h1>
                <p>Россия, <?= $user->city->name ?>, <?= FormatDate::formatDateAsDuration($user->dt_birth) ?></p>
                <div class="profile-mini__name five-stars__rate">
                    <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                    <b><?= $user->rating ?></b>
                </div>
                <b class="done-task">Выполнил <?= Yii::$app->i18n->format('{n, plural, one{# заказ} many{# заказов} other{# заказа}}', ['n' => $user->executorTasksCount], 'ru_RU') ?></b>
                <b class="done-review">Получил <?= Yii::$app->i18n->format('{n, plural, one{# отзыв} many{# отзывов} other{# отзыва}}', ['n' => $user->opinionsCount], 'ru_RU') ?></b>
            </div>
            <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                <span>Был на сайте <?= Yii::$app->formatter->asRelativeTime($user->dt_last_visit) ?></span>
                <a href="#"><b></b></a>
            </div>
        </div>
        <div class="content-view__description">
            <p><?= $user->info ?></p>
        </div>
        <div class="user__card-general-information">
            <div class="user__card-info">
                <h3 class="content-view__h3">Специализации</h3>
                <div class="link-specialization">
                    <?php foreach ($user->categories as $category) : ?>
                        <a href="#" class="link-regular"><?= $category->name ?></a>
                    <?php endforeach;; ?>
                </div>
                <h3 class="content-view__h3">Контакты</h3>
                <div class="user__card-link">
                    <a class="user__card-link--tel link-regular" href="#"><?= $user->phone ?></a>
                    <a class="user__card-link--email link-regular" href="#"><?= $user->email ?></a>
                    <a class="user__card-link--skype link-regular" href="#"><?= $user->skype ?></a>
                </div>
            </div>
            <div class="user__card-photo">
                <?php if (count($user->photoOfWorks)) : ?>
                    <h3 class="content-view__h3">Фото работ</h3>
                    <?php foreach ($user->photoOfWorks as $photo) : ?>
                        <a href="#"><img src="<?= $photo->url ?>" width="85" height="86" alt="Фото работы"></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="content-view__feedback">
        <?php if ($user->opinionsCount) : ?>
            <h2>Отзывы<span>(<?= $user->opinionsCount ?>)</span></h2>
            <div class="content-view__feedback-wrapper reviews-wrapper">
                <?php foreach ($user->executorOpinions as $opinion) : ?>
                    <div class="feedback-card__reviews">
                        <p class="link-task link">Задание <a href="#" class="link-regular">«<?= $opinion->task->title ?>»</a></p>
                        <div class="card__review">
                            <a href="#"><img src="<?= $opinion->customer->avatar ?? '../img/no-avatar.svg' ?>" width="55" height="54"></a>
                            <div class="feedback-card__reviews-content">
                                <p class="link-name link"><a href="#" class="link-regular"><?= $opinion->customer->name ?></a></p>
                                <p class="review-text">
                                    <?= $opinion->content ?>
                                </p>
                            </div>
                            <div class="card__review-rate">
                                <p class="five-rate big-rate"><?= $opinion->rate ?><span></span></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<section class="connect-desk">
    <div class="connect-desk__chat">

    </div>
</section>
