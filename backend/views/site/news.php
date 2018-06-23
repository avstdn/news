<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 13.05.18
 * Time: 18:53
 */

use backend\models\Articles;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $article Articles */

?>
<div class="single-news">
    <div class="row">
        <div class="col-md-6 col-md-push-3">
            <img src="<?= Url::to('@web/images/').$article->image_path ?>">
        </div>
    </div>
    <hr>
    <p><?= $article->article ?></p>
</div>
<hr>
<span>Время просмотра новости: <time>0</time> сек.</span>