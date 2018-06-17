<?php


use yii\bootstrap\Modal;
use \backend\components\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $articles[] Articles */

$this->title = 'My Yii Application';

$this->registerJs(<<<JS

$(document)
    .on('click', '.show-news', function(e) {
        e.preventDefault();
        var self = $(this);
        var modal = $("#modal-news");
        modal.find('.modal-header').text(self.data('title'));
        modal.modal('show');
        modal.find('.modal-body').html('').load(self.data('url'), function(response, status, xhr) {
            if (status === "error") {
                modal.modal('hide');
                alert('Ошибка');
            }
        });
        return false;
    })
    .on('click', '.like-ico', function(e) {
        e.preventDefault();
        var self = $(this);
        // var modal = $("#modal-news");
        if (self.hasClass('ico-off')) {
            self.attr('class', 'like-ico like-ico-on');
            console.log('white');
        } else {
            self.attr('class', 'like-ico ico-off');
        }
        // modal.find('.modal-header').text(self.data('title'));
        // modal.modal('show');
        // modal.find('.modal-body').html('').load(self.data('url'), function(response, status, xhr) {
        //     if (status === "error") {
        //         modal.modal('hide');
        //         alert('Ошибка');
        //     }
        // });
        // return false;
    })
    .on('click', '.dislike-ico', function(e) {
        e.preventDefault();
        var self = $(this);
        // var modal = $("#modal-news");
        if (self.hasClass('ico-off')) {
            self.attr('class', 'dislike-ico dislike-ico-on');
        } else {
            self.attr('class', 'dislike-ico ico-off');
        }
    });



var stopwatchTimeout;
var seconds = 0;

$('#modal-news')
    .on('shown.bs.modal', function (e) {
        var h1 = document.getElementsByTagName('h1')[0];
        seconds = 0;
    
        
        function add() {
            seconds++;
            h1.textContent = seconds;
            timer();
        }
    
        function timer() {
            stopwatchTimeout = setTimeout(add, 1000);
        }
        timer();
    })
    .on('hidden.bs.modal', function(e) {
        console.log(seconds);
        clearTimeout(stopwatchTimeout);
    });

JS
);

?>

<?= Modal::widget(['class' => 'modal-md', 'id' => 'modal-news']);?>

<div class="col-md-5 col-md-push-3">
    <? foreach ($articles as $i => $article): ?>
        <div class="news-wrapper show-news" data-title="<?= $article->title ?>" data-url="<?= Url::to(['site/show-news', 'id' => $article->id])?>" >
            <?= Html::img(Url::to('@web/images/').$article->image_path); ?>
            <div class="news-title-wrapper">
                <?= Html::tag('h3', $article->title, ['class' => 'news-title']); ?>
            </div>
        </div>
        <div class="text-center" style="background: rgba(0, 0, 0, 0.9);">
            <div style="padding: 5px 0;">
                <span class="like-ico ico-off"><?=Html::fa('heart fa-2x')?></span>
                <span class="dislike-ico ico-off"><?=Html::fa('thumbs-down fa-2x')?></span>
            </div>
        </div>
        <?= Html::tag('p', $article->firstTag->tag.', '.$article->secondTag->tag); ?>
        <hr>
    <? endforeach; ?>
</div>