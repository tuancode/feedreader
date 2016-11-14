<?php

namespace app\commands;

use app\models\Feed;
use app\models\FeedSubscribe;
use yii\console\Controller;
use yii\helpers\Console;
use Yii;

/**
 * This controller support add feed address from command line.
 */
class FeedController extends Controller
{
    /**
     * Add feed address.
     *
     * @param string $url Rss feed url
     * @return integer
     */
    public function actionAdd($url)
    {
        $model = new FeedSubscribe(new Feed());
        $model->setAddress($url);
        if ($model->save()) {
            $message = 'Add feeds successful';
            Yii::info($message, 'console');
            $this->stdout("Success: ", Console::BOLD, Console::FG_GREEN);
            echo $message . "\n";
            return self::EXIT_CODE_NORMAL;
        } else {
            $message = $model->getFirstError('address');
            Yii::error($message, 'console');
            $this->stdout("Error: ", Console::BOLD, Console::FG_RED);
            echo $message . "\n";
            return self::EXIT_CODE_ERROR;
        }
    }
}
