<?php


use backend\components\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $articles[] Articles */

$this->title = 'Новости';

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
            self.parent().parent().parent().addClass('animated fadeOutLeftBig').hide(500);
            // self.parent().parent().prev().addClass('animated fadeOutLeftBig');
            // console.log();
        } else {
            self.attr('class', 'dislike-ico ico-off');
            // self.parent().parent().closest('div.news-wrapper').attr('class', 'fadeOutLeftBig');
        }
    });



var stopwatchTimeout;
var seconds = 0;

$('#modal-news')
    .on('shown.bs.modal', function (e) {
        var h1 = document.getElementsByTagName('time')[0];
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

<?= Modal::widget(['size' => Modal::SIZE_LARGE, 'id' => 'modal-news']);?>



<div class="col-md-6 col-md-push-3">

    <? foreach ($articles as $i => $article): ?>
        <div>
            <div class="news-wrapper show-news" data-title="<?= $article->title ?>" data-url="<?= Url::to(['site/show-news', 'id' => $article->id])?>" >
                <?= Html::img(Url::to('@web/images/').$article->image_path); ?>
                <div class="news-title-wrapper" style="cursor: default">
                    <?= Html::tag('h3', $article->title, ['class' => 'news-title']); ?>
                </div>
            </div>
            <div class="text-center unselectable" style="background: rgba(0, 0, 0, 0.9);">
                <div style="padding: 5px 0;">
                    <span class="like-ico ico-off" style="display: inline-block; cursor: pointer;"><?=Html::fa('heart fa-2x')?><span style="font-size: 18px; vertical-align: bottom;"> Нравится</span></span>
                    <span style="border-left: 1px solid #fff; height: 25px; vertical-align: bottom; display: inline-block;"></span>
                    <span class="dislike-ico ico-off" style="display: inline-block; cursor: pointer;"><?=Html::fa('thumbs-down fa-2x')?><span style="font-size: 18px; vertical-align: bottom;"> Не нравится</span></span>
                </div>
            </div>
            <?= Html::tag('p', '#'.$article->firstTag->tag.', #'.$article->secondTag->tag, ['style' => ['margin' => '10px 0']]); ?>
            <hr style="margin-top: 0;">
        </div>
    <? endforeach; ?>
</div>