<?php

/** @var yii\web\View $this */
/** @var string $content */
/** @var array $user */

use app\assets\AppAsset;
use app\models\Users;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

$user = Users::findIdentity(\Yii::$app->user->getId());
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<header class="page-header">
    <nav class="main-nav">
        <a href='/' class="header-logo">
            <img class="logo-image" src="/img/logotype.png" width=227 height=60 alt="taskforce">
        </a>
        <div class="nav-wrapper">
            <ul class="nav-list">
                <li class="list-item list-item--active">
                    <a class="link link--nav">Новое</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Мои задания</a>
                </li>
                <?php if (Yii::$app->user->can('client')): ?>
                    <li class="list-item">
                        <a href="<?= Url::to(['/add-task']); ?>" class="link link--nav" >Создать задание</a>
                    </li>
                <?php endif; ?>
                <li class="list-item">
                    <a href="<?= Url::to(['profile/settings']) ?>" class="link link--nav" >Настройки</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php if(!Yii::$app->user->isGuest): ?>
        <div class="user-block">
        <a href="#">
            <img class="user-photo" src="<?= $user->avatarPath; ?>" width="55" height="55" alt="<?= $user->full_name; ?>">
        </a>
        <div class="user-menu">
            <p class="user-name"><?= $user->full_name; ?></p>
            <div class="popup-head">
                <ul class="popup-menu">
                    <li class="menu-item">
                        <a href="<?= Url::to(['profile/settings']) ?>" class="link">Настройки</a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="link">Связаться с нами</a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= Url::to(['tasks/logout']) ?>" class="link">Выход из системы</a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>
</header>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
