<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 13.05.18
 * Time: 18:53
 */

use yii\helpers\Url;
use \backend\models\Articles;

/* @var $this yii\web\View */
/* @var $article Articles */

?>
<div class="single-news">
    <div class="row">
        <div class="col-md-8 col-md-push-2">
            <img src="<?= Url::to('@web/images/').$article->image_path ?>">
        </div>
    </div>
    <hr>
    <p><?= $article->article ?></p>
</div>
<!--<hr>-->
<!--<h1><time>0</time></h1>-->