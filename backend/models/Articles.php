<?php

namespace backend\models;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property int $article_id
 * @property string $title
 * @property string $url
 * @property string $language
 * @property string $image_url
 * @property string $image_type
 * @property string $date
 * @property string $category
 * @property string $content
 * @property string $first_tag
 * @property string $second_tag
 * @property string $article
 * @property string $image_path
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url', 'language', 'date'], 'required'],
            [['date'], 'safe'],
            [['title', 'content', 'article'], 'string'],
            [['language', 'image_type'], 'string', 'max' => 32],
            [['url', 'image_url', 'image_path'], 'string', 'max' => 128],
            [['category'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
            'language' => 'Language',
            'image_url' => 'Image Url',
            'image_type' => 'Image Type',
            'date' => 'Date',
            'category' => 'Category',
            'content' => 'Content',
        ];
    }

    public function getFirstTag()
    {
        return $this->hasOne(Tags::class, ['id' => 'first_tag']);
    }

    public function getSecondTag()
    {
        return $this->hasOne(Tags::class, ['id' => 'second_tag']);
    }
}
