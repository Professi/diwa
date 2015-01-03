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
        <?php $this->beginBody();?>
        <?= $this->render('header.php', ['asset' => $asset]); ?>
        <?= $this->render('content.php', ['content' => $content]); ?>
        <?= $this->render('footer.php'); ?>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>
