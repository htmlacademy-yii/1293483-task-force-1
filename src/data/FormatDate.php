<?php
namespace htmlacademy\data;

use Yii;

class FormatDate
{
    /**
     * Форматирует дату как продолжительность
     *
     * @param string $date
     *
     * @return string
     */
    static public function formatDateAsDuration(string $date): string
    {
        $currentDate = date_create('now');
        $date = date_create($date);
        $diff = date_diff($currentDate, $date);

        if ($diff->format('%y')) {
            $duration = Yii::$app->i18n->format('{n, plural, one{# год} many{# лет} other{# года}}', ['n' => $diff->format('%y')], 'ru_RU');
        } elseif ($diff->format('%m')) {
            $duration = Yii::$app->i18n->format('{n, plural, one{# месяц} many{# месяцев} other{# месяца}}', ['n' => $diff->format('%m')], 'ru_RU');
        } else {
            $duration = Yii::$app->i18n->format('{n, plural, one{# день} many{# дней} other{# дня}}', ['n' => $diff->format('%d')], 'ru_RU');
        }

        return $duration;
    }
}