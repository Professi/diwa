<?php
/* Copyright (C) 2014  Christian Ehringfeld, David Mock
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use yii\helpers\Html;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

$asset = AppAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="<?php echo $asset->baseUrl; ?>/favicon.ico">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $asset->baseUrl; ?>/favicon.ico">
        <?= Html::csrfMetaTags() ?>
        <title><?php echo Html::encode($this->title); ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <h1 class="text-center hide show-for-print" style="font-family: 'ClickerScript-Regular';"><?= Yii::t('app', 'DiWA'); ?></h1>
        <nav class="top-bar hide-on-print" data-topbar data-options="is_hover: false">
            <ul class="title-area">
                <li class="name esta-logo">
                    <h2> 
                        <?php echo Html::a(Yii::t('app', 'DiWA'), ['/site/index']); ?>
                    </h2>
                </li>
                <li class="toggle-topbar menu-icon"><a href=""><span>Menu</span></a></li>
            </ul>
            <section class="top-bar-section">
                <ul class="right">
                    <li>
                        <a href="http://<?php echo Yii::$app->params['websiteLink']; ?>" target="_blank">
                            <img id="logo" 
                                 src="<?php echo $asset->baseUrl; ?>/img/dictionary.gif"
                                 alt="<?php echo Yii::$app->params['altWebsiteLink'] ?>">
                                 <?php echo Yii::t('app', 'DiWA'); ?>
                        </a>
                    </li>
                    <li class="toggle-topbar menu-icon"><a href=""><span>Menu</span></a></li>
                </ul>
                <ul class="left show-for-small-only">
                    <?php
                    if (!Yii::$app->user->isGuest) {
                        echo $this->context->getMenu()->generate(true);
                    }
                    ?>
                    <li>
                        <a onClick="event.preventDefault();
                                window.print();" href="#">
                            <i class="fi-print"></i><?php echo Yii::t('app', 'Print'); ?>
                        </a>
                    </li>
                </ul>
            </section>
        </nav>
        <div class="sticky sticky-nav hide-for-small hide-on-print">
            <ul class="medium-block-grid-6 large-block-grid-8 text-center ul-nav" data-topbar>
                <?php
                echo $this->context->getMenu()->generate(false);
                ?>
                <li>
                    <a onClick="event.preventDefault();
                            window.print();" href="#">
                        <i class="fi-print"></i><span><?php echo Yii::t('app', 'Print'); ?></span>
                    </a>
                </li>
                <!--<li class="no-highlight">
                    <div id="language-selector">
                        <i class="fi-comment-quotes"></i>
                <?php
                /*                 * @todo */
// pheme\i18n\LanguageSwitcher::widget(); 
                ?>
                    </div>
                </li>-->
            </ul>
        </div>
        <section role="main" class="content-wrapper">
            <div class="row hide-on-print">
                <div class="small-12 columns small-centered">
                    <?php if (Yii::$app->user->hasFlash('success')) { ?>
                        <div data-alert class="alert-box" tabindex="0" aria-live="assertive" role="dialogalert">
                            <?php echo Yii::$app->user->getFlash('success'); ?>
                        </div>
                    <?php } if (Yii::$app->user->hasFlash('failMsg')) { ?>
                        <div data-alert class="alert-box alert" tabindex="0" aria-live="assertive" role="dialogalert">
                            <?php echo Yii::$app->user->getFlash('failMsg'); ?>            
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
                    <?php echo Yii::t('app', 'Copyright'); ?> &copy; <?php
                    echo date('Y') . ' ';
                    echo ('Christian Ehringfeld');
                    ?>
                </p>
            </div>
            <div class="large-4 columns hide-for-small js_hide"></div>
            <div class="large-4 columns hide-for-small js_show">
                <p>
                    <?php echo Yii::t('app', 'Press <kbd>Esc</kbd> to toggle the navigation menu.'); ?> 
                </p>
            </div>
            <div class="small-6 large-4 columns">
                <?php
                echo \yii\widgets\Menu::widget([
                    'options' => ['class' => 'right inline-list'],
                    'items' => [
                        ['label' => Yii::t('app', 'FAQ'), 'url' => ['/site/faq']],
                        ['label' => Yii::t('app', 'Imprint'), 'url' => ['/site/imprint']],
                        ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
                        ['label' => Yii::t('app', 'Statistics'), 'url' => ['/site/statistics'], 'visible' => Yii::$app->user->isAdmin() || Yii::$app->user->isTerminologist()]
                    ],
                ]);
                ?>
            </div>
        </div> 
        <div class="infobox" style="display: none;"><p></p></div>
                <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
