<?php

use app\models\Users;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var Users $model */
/** @var array $cities */

$this->title = 'Taskforce';

$this->registerCssFile('https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css');

$this->registerJsFile('https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js');
$this->registerJsFile('@web/js/autocomplit.js');
?>

<main class="container container--registration">
    <div class="center-block">
        <div class="registration-form regular-form">
            <?php $form = ActiveForm::begin([
                'fieldConfig' => [
                    'inputOptions' => [
                        'class' => ''
                    ],
                    'errorOptions' => [
                            'tag' => 'span',
                            'class' => 'help-block'
                    ]
                ]
            ]); ?>
                <h3 class="head-main head-task">Регистрация нового пользователя</h3>
                <?= $form->field($model, 'full_name'); ?>
                <div class="half-wrapper">
                    <?= $form->field($model, 'email')->input('email'); ?>
                    <?= $form->field($model, 'location', [
                        'inputOptions' => [
                            'id' => 'location',
                            'class' => 'location'
                        ]]); ?>
                </div>
                <?= $form->field($model, 'latitude', ['template' => "{input}"])->hiddenInput(['id' => 'latitude']) ?>
                <?= $form->field($model, 'longitude', ['template' => "{input}"])->hiddenInput(['id' => 'longitude']) ?>
                <div class="half-wrapper">
                    <?= $form->field($model, 'password')->passwordInput(); ?>
                </div>
                <div class="half-wrapper">
                    <?= $form->field($model, 'password_repeat')->passwordInput(); ?>
                </div>
                <?= $form->field($model, 'is_worker', ['template' => "{label}\n{input}"])->checkbox(
                        [
                            'uncheck' => null,
                            'labelOptions' => [
                                'class' => 'control-label checkbox-label'
                            ],
                            'checked' => true
                        ]
                ); ?>
                <?= Html::submitInput('Создать аккаунт', ['class' => 'button button--blue']); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</main>
