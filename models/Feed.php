<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "feed".
 *
 * @property integer  $id
 * @property string   $title
 * @property string   $description
 * @property string   $link
 * @property integer  $category_id
 * @property integer  $pubDate
 * @property string   $formattedPubDate
 * @property integer  $created_at
 * @property integer  $updated_at
 *
 * @property Category $category
 */
class Feed extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feed';
    }

    /**
     * @param integer $categoryId
     * @param array $config
     */
    public function __construct($categoryId = null, $config = [])
    {
        $this->category_id = $categoryId;

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'link', 'category_id', 'formattedPubDate'], 'required'],
            [['description'], 'string'],
            [['category_id', 'pubDate', 'created_at', 'updated_at'], 'integer'],
            [['title', 'link'], 'string', 'max' => 255],
            ['link', 'url', 'defaultScheme' => 'http'],
            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::className(),
                'targetAttribute' => ['category_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'title' => 'Title',
            'description' => 'Description',
            'link' => 'Link',
            'category_id' => 'Category',
            'pubDate' => 'PubDate',
            'created_at' => 'Created',
            'updated_at' => 'Modified',
        ];
    }

    /**
     * Defines write ability for virtual property 'formattedPubDate'.
     *
     * @param string $value
     */
    public function setFormattedPubDate($value)
    {
        $this->pubDate = Yii::$app->formatter->asTimestamp($value);
    }

    /**
     * Defines read ability for virtual property 'formattedPubDate'.
     *
     * @return string
     */
    public function getFormattedPubDate()
    {
        return Yii::$app->formatter->asDate($this->pubDate);
    }

    /**
     * Declares `category` relation.
     *
     * @return yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
