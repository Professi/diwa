<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$menu = array(//icon,label,url,visible(bool)
    array('fi-power', Yii::t('$app', 'Logout'), array('site/logout'), true),
);
?>


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$$app->language ?>">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="icon" href="<?php echo $this->assetsDir; ?>/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->assetsDir; ?>/favicon.ico">
    <?= Html::csrfMetaTags() ?>
    <title><?php echo Html::encode($this->pageTitle); ?></title>
    <?php $this->head() ?>
</head>
    
    <body>
        <?php $this->beginBody() ?>




        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => 'My Company',
                'brandUrl' => Yii::$$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    Yii::$$app->user->isGuest ?
                            ['label' => 'Login', 'url' => ['/site/login']] :
                            ['label' => 'Logout (' . Yii::$$app->user->identity->username . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
            ?>
        </div>

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    <h1 class="text-center hide show-for-print" style="font-family: 'ClickerScript-Regular';"><?= Yii::t('$app', 'Elternsprechtag'); ?></h1>
    <nav class="top-bar hide-on-print" data-topbar data-options="is_hover: false">
        <ul class="title-area">
            <li class="name esta-logo">
                <h2>
                    <?php echo Html::link(Yii::t('$app', 'Elternsprechtag'), 'index.php'); ?>
                </h2>
            </li>
            <li class="toggle-topbar menu-icon"><a href=""><span>Menu</span></a></li>
        </ul>
        <section class="top-bar-section">
            <ul class="right">
                <li>
                    <a href="http://<?php echo Yii::$app()->params['schoolWebsiteLink']; ?>" target="_blank">
                        <img id="logo_school" 
                             src="<?php echo $this->assetsDir . Yii::$app()->params['logoPath']; ?>" 
                             alt="<?php echo Yii::$app()->params['schoolName'] ?>">
                             <?php echo Yii::$app()->params['schoolName'] ?>
                    </a>
                </li>
                <li class="toggle-topbar menu-icon"><a href=""><span>Menu</span></a></li>
            </ul>
            <ul class="left show-for-small-only">
                <?php
                if (!Yii::$app()->user->isGuest) {
                    echo $this->generateFoundation5Menu($menu, true);
                }
                ?>
                <li>
                    <a onClick="event.preventDefault();
                            window.print();" href="#">
                        <i class="fi-print"></i><?php echo Yii::t('$app', 'Drucken'); ?>
                    </a>
                </li>
            </ul>
        </section>
    </nav>
    <div class="sticky sticky-nav hide-for-small hide-on-print">
        <ul class="medium-block-grid-6 large-block-grid-8 text-center ul-nav" data-topbar>
            <?php
            if (!Yii::$app()->user->isGuest) {
                echo $this->generateFoundation5Menu($menu, false);
            }
            ?>
            <li>
                <a onClick="event.preventDefault();
                        window.print();" href="#">
                    <i class="fi-print"></i><span><?php echo Yii::t('$app', 'Drucken'); ?></span>
                </a>
            </li>
            <li class="no-highlight">
                <div id="language-selector">
                    <i class="fi-comment-quotes"></i>
                    <?php $this->widget('$application.components.widgets.LanguageSelector'); ?>
                </div>
            </li>
        </ul>
    </div>
    <section role="main" class="content-wrapper">
        <div class="row hide-on-print">
            <div class="small-12 columns small-centered">
                <?php if (Yii::$app()->user->hasFlash('success')) { ?>
                    <div data-alert class="alert-box" tabindex="0" aria-live="assertive" role="dialogalert">
                        <?php echo Yii::$app()->user->getFlash('success'); ?>
                    </div>
                <?php } if (Yii::$app()->user->hasFlash('failMsg')) { ?>
                    <div data-alert class="alert-box alert" tabindex="0" aria-live="assertive" role="dialogalert">
                        <?php echo Yii::$app()->user->getFlash('failMsg'); ?>            
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php echo $content; ?>
    </section>
    <div class="footer row hide-for-print">
        <hr>
        <div class="small-6 large-4 columns">
            <p>
                <?php echo Yii::t('$app', 'Copyright'); ?> &copy; <?php
                echo date('Y') . ' ';
                echo (!empty(Yii::$app()->params['schoolName'])) ? Yii::$app()->params['schoolName'] : Yii::t('$app', 'ESTA-Team');
                ?>
            </p>
        </div>
        <div class="large-4 columns hide-for-small js_hide"></div>
        <div class="large-4 columns hide-for-small js_show">
            <p>
                <?php echo Yii::t('$app', 'Drücken Sie <kbd>Esc</kbd> um das Navigationsmenü ein- bzw. auszublenden.'); ?> 
            </p>
        </div>
        <div class="small-6 large-4 columns">
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'htmlOptions' => array('class' => 'right inline-list'),
                'items' => array(
                    array('label' => Yii::t('$app', 'Statistik'), 'url' => array('/site/statistics'),
                        'visible' => (!Yii::$app()->user->isGuest() && Yii::$app()->user->checkAccess(ADMIN))),
                    array('label' => Yii::t('$app', 'Impressum'), 'url' => array('/site/page', 'view' => 'impressum')),
                    array('label' => Yii::t('$app', 'Kontakt'), 'url' => array('/site/contact')),
            )));
            ?>
        </div>
    </div> 
    <div class="infobox" style="display: none;"><p></p></div>
        
        
        
        
        
        

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
