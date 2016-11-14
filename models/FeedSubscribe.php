<?php
namespace app\models;

use yii\base\Model;
use yii\helpers\StringHelper;
use yii\validators\UrlValidator;
use Yii;

/**
 * This is the model class for handling subscribe feed
 *
 * @property string  $address
 * @property \SimpleXMLElement[] $feedXmls
 */
class FeedSubscribe extends Model
{
    /**
     * @var string
     */
    private $address;
    /**
     * @var \SimpleXMLElement[]
     */
    private $feedXmls = [];
    /**
     * @var Feed
     */
    private $feed;

    /**
     * @param Feed $feed
     * @param array $config
     */
    public function __construct(Feed $feed, $config = [])
    {
        $this->feed = $feed;

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['address', 'required'],
            ['address', 'validateFeed']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'address' => 'Address',
        ];
    }

    /**
     * Validates feed.
     * This method serves as the multiple validation for feed urls.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateFeed($attribute, $params)
    {
        $urlValidator = new UrlValidator();
        $addresses = StringHelper::explode($this->$attribute);
        foreach ($addresses as $url) {
            libxml_use_internal_errors(true);
            if (!$urlValidator->validate($url)) {
                $this->addError($attribute, "{$url} is not a valid URL.");
            } elseif (!$xml = simplexml_load_file($url)) {
                $this->addError($attribute, "Failed loading feed from {$url}");
            } else {
                $this->setFeedXmls($xml);
            }
        }
    }

    /**
     * Defines write ability for property 'address'.
     *
     * @param string $value
     */
    public function setAddress($value)
    {
        $this->address = $value;
    }

    /**
     * Defines read ability for property 'address'.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Defines write ability for property 'feedXmls'.
     *
     * @param \SimpleXMLElement $value
     */
    public function setFeedXmls(\SimpleXMLElement $value)
    {
        $this->feedXmls[] = $value;
    }

    /**
     * Defines read ability for property 'feedXmls'.
     *
     * @param string $value
     */
    public function getFeedXmls()
    {
        return $this->feedXmls;
    }

    /**
     * Saves feed to database.
     * Feed's title is saved to `category` and items is saved to `feed`.
     *
     * @param string $runValidation whether to perform validation (calling [[validate()]])
     * @return boolean whether the saving succeeded (i.e. no validation errors occurred).
     */
    public function save($runValidation = true)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }

        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $feeds = [];
            foreach ($this->getFeedXmls() as $feedXml) {
                // Create feed categories
                $category = new Category(); //TODO: It should not directly new object inside class
                $category->title = (string) $feedXml->channel->title;
                $category->save();

                // Collect feed items
                foreach ($feedXml->channel->item as $item) {
                    $feeds[] = [
                        $item->title,
                        $item->description,
                        $item->link,
                        $category->id,
                        Yii::$app->formatter->asTimestamp($item->pubDate),
                        time(),
                        time()
                    ];
                }
            }
            $db->createCommand()->batchInsert(
                $this->feed->tableName(),
                array_keys($this->feed->getAttributes(null, ['id'])),
                $feeds
            )->execute();

            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}
