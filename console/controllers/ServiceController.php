<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 06.11.17
 * Time: 23:59
 */

namespace console\controllers;

use backend\models\Articles;
use backend\models\Tags;
use common\models\User;
use igogo5yo\uploadfromurl\UploadFromUrl;
use keltstr\simplehtmldom\SimpleHTMLDom;
use PicoFeed\PicoFeedException;
use PicoFeed\Reader\Reader;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

class ServiceController extends Controller
{
    public function actionLoadUser($name)
    {
        $user = new User();
        $string = (string) 0;
        $user->username = $name;
        $user->setPassword("123456");
        $user->email = "$name@adv-cake.ru";
//        $user->role = "admin";
//        $user->birthday = date('Y-m-d', rand(strtotime("-70 years"), strtotime("-10 years")));
        $user->generateAuthKey();
        if ($user->save()) {
            $this->stdout("User $name created\n");
        } else {
            $this->stdout("Error:".print_r($user->errors));
        }
    }

    public function actionRelation()
    {
        /** @var $articles Articles */
        $articles = Articles::findOne('1');
        $this->stdout($articles->firstTag->tag);
        $this->stdout($articles->secondTag->tag);
        $this->stdout("\n");
        $html = SimpleHTMLDom::file_get_html('https://lenta.ru/news/2018/02/23/mcdonalds/');
//        $html->find('div[id=hello]', 0)
        $articleBody = $html->find('div[itemprop=articleBody] p');

        $articleText = '';
        foreach ($articleBody as $pTag) {
            $articleText .= $pTag->plaintext;
        }
//        $articleBody = $html->find('div[itemprop=articleBody] p', 0)->outertext;
//        $this->stdout($articleBody);
        $this->stdout($articleText);
    }

    public function actionAddText()
    {
        try {
            $articles = Articles::find()
                ->select(['article_id', 'url'])
                ->where(['article' => null])
                ->asArray()
                ->all();
            $this->stdout(count($articles));
            $this->stdout("\n");
            $articlesCnt = 1;
            $updateCnt = 0;

//          Print the feed properties with the magic method __toString()
            foreach($articles as $i => $article) {
                $this->stdout("$articlesCnt ");
                $articlesCnt++;
                $html = SimpleHTMLDom::file_get_html($article['url']);
                $articleBody = $html->find('div[itemprop=articleBody] p');
                $articleText = '';

                foreach ($articleBody as $pTag) {
                    $articleText .= $pTag->plaintext;
                }

                $updateCnt += Yii::$app->db->createCommand()
                    ->update(Articles::tableName(),
                        ['article' => $articleText], //columns and values
                        ['article_id' => $article['article_id']]) //condition, similar to where()
                    ->execute();
            }

            $this->stdout("\n$updateCnt articles were successfully updated\n");
        }
        catch (PicoFeedException $e) {
            // Do something...
            $this->stdout($e);
        }
    }

    public function actionAddTags()
    {
        try {
            $articles = Articles::find()
                ->select(['article_id', 'url'])
                ->where(['and', ['first_tag' => null], ['second_tag' => null]])
                ->asArray()
                ->all();
            $this->stdout(count($articles));
            $this->stdout("\n");
            $articlesCnt = 1;
            $updateCnt = 0;

//          Print the feed properties with the magic method __toString()
            foreach($articles as $i => $article) {
                $this->stdout("$articlesCnt ");
                $articlesCnt++;
                $firstTag = null;
                $secondTag = null;
                $html = SimpleHTMLDom::file_get_html($article['url']);
                $title = explode(':', $html->find('title', 0)->plaintext);
                $tagsAll = Tags::find()->asArray()->all();

                foreach ($tagsAll as $tag) {
                    $tag['tag'] == trim($title[1]) && $firstTag = $tag['id'];
                    $tag['tag'] == trim($title[2]) && $secondTag = $tag['id'];
                }

                if (!$firstTag || !$secondTag) {
                    unset($articles[$i]);
                    continue;
                }

                $updateCnt += Yii::$app->db->createCommand()
                    ->update(Articles::tableName(),
                        ['first_tag' => $firstTag, 'second_tag' => $secondTag], //columns and values
                        ['article_id' => $article['article_id']]) //condition, similar to where()
                    ->execute();
            }

            $this->stdout("\n$updateCnt articles were successfully updated\n");
        }
        catch (PicoFeedException $e) {
            // Do something...
            $this->stdout($e);
        }
    }

    public function actionTest()
    {
//        $html = file_get_html('http://www.google.com/');
//        $title = $html->find('title', 0)->innertext;
//        $html->clear(); //important
//        echo $title;
        $html = SimpleHTMLDom::file_get_html('https://lenta.ru/news/2018/02/21/bavaria_beshi/');
        $title = explode(':', $html->find('title', 0)->plaintext);
        $tags = implode(',', [$title[1], $title[2]]);

        $tagsArray = Tags::find()->asArray()->all();
        $test = [];


        foreach ($tagsArray as $tag) {
            if ($tag['tag'] == trim($title[1]) || $tag['tag'] == trim($title[2])) {
                $test[] = $tag['id'];
            }
        }

        print_r($test);
//        print_r($tags);
    }

    /**
     *
     */
    public function actionParseRss()
    {

        try {

            $reader = new Reader;
            $articlesArray = [];

            // Return a resource
            $resource = $reader->download('https://lenta.ru/rss/news');

            // Return the right parser instance according to the feed format
            $parser = $reader->getParser(
                $resource->getUrl(),
                $resource->getContent(),
                $resource->getEncoding()
            );

            // Return a Feed object
            $feed = $parser->execute();
            $articles = $feed->getItems();

            // Print the feed properties with the magic method __toString()
            $articlesCnt = 1;

            Console::startProgress(0, count($articles));
            foreach ($articles as $i => $article) {
//                $this->stdout("$articlesCnt ");
                if (!isset($article->getCategories()[0])) continue;
                Console::updateProgress($i, count($articles));

                $firstTag = null;
                $secondTag = null;
                $html = SimpleHTMLDom::file_get_html($article->getUrl());
                $title = explode(':', $html->find('title', 0)->plaintext);
                $tagsAll = Tags::find()->asArray()->all();

                $articleBody = $html->find('div[itemprop=articleBody] p');
                $articleText = '';
                foreach ($articleBody as $pTag) {
                    $articleText .= $pTag->plaintext;
                }

                foreach ($tagsAll as $tag) {
                    $tag['tag'] == trim($title[1]) && $firstTag = $tag['id'];
                    $tag['tag'] == trim($title[2]) && $secondTag = $tag['id'];
                }

                if (!$firstTag || !$secondTag) continue;

                $articlesArray[] = [
                    'article_id' => $article->getId(),
                    'title' => $article->getTitle(),
                    'url' => $article->getUrl(),
                    'language' => $article->getLanguage(),
                    'image_url' => $article->getEnclosureUrl(),
                    'image_type' => $article->getEnclosureType(),
                    'date' => date('Y-m-d', $article->getDate()->getTimestamp()),
                    'category' => $article->getCategories()[0],
                    'content' => strip_tags($article->getContent()),
                    'first_tag' => $firstTag,
                    'second_tag' => $secondTag,
                    'article' => $articleText,
                ];
                $articlesCnt++;
            }
            Console::endProgress('RSS parsing finished');

            $existArticles = Articles::find()->select('article_id')->column();
            foreach($articlesArray as $i => $article) {
                if (ArrayHelper::isIn($article['article_id'], $existArticles)) unset($articlesArray[$i]);
                elseif (!ArrayHelper::getValue($article, 'image_type', false)) unset($articlesArray[$i]);
                else {
                    /* Download image from image_url */
                    $url = $article['image_url'];
                    $path = Yii::getAlias('@backend/web/images/');
                    $img = UploadFromUrl::initWithUrl($url);
                    $name = substr($url, strrpos($url, '/') + 1);

                    if ($img->saveAs($path.$name)) {
                        $articlesArray[$i]['image_path'] = $name;
//                        $this->stdout("\n$i image has been uploaded\n");
                    } else $this->stdout("\nError on image $name save\n");
                }
            }

            $insertCnt = \Yii::$app->db->createCommand()->batchInsert(
                Articles::tableName(),
                [
                    'article_id',
                    'title',
                    'url',
                    'language',
                    'image_url',
                    'image_type',
                    'date',
                    'category',
                    'content',
                    'first_tag',
                    'second_tag',
                    'article',
                    'image_path'
                ], $articlesArray)->execute();

            $this->stdout("\n$insertCnt articles were successfully inserted\n");
        }
        catch (PicoFeedException $e) {
            // Do something...
            $this->stdout($e);
        }

    }

    public function actionUploadImages()
    {
        $articles = Articles::find()->all();
        $totalArticlesCnt = Articles::find()->count();
        $articlesCnt = 0;

        /** @var $article Articles  */
        foreach ($articles as $article) {
            $articlesCnt++;
            $url = $article->image_url;
            $path = \Yii::getAlias('@upload/images/');
            $img = UploadFromUrl::initWithUrl($url);
            $name = substr($url, strrpos($url, '/') + 1);
            $fullPath = $path.$name;

            if ($img->saveAs($fullPath)) {
                $article->image_path = $name;

                if ($article->save()) {
                    $this->stdout("$articlesCnt images of $totalArticlesCnt has been successfully uploaded\n");
                    $this->stdout("$name\n");
                } else {
                    $this->stdout("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
                    $this->stdout("Uploading image $name is fault\n");
                    $this->stdout("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
                }
            } else {
                $this->stdout("!!!!!!!!!!!!!!!!!!!!!!!!!!!");
                $this->stdout("Save image $name is failed!\n");
                $this->stdout("!!!!!!!!!!!!!!!!!!!!!!!!!!!");
                break;
            }

        }
    }

}