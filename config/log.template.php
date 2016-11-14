<?php

return [
   'traceLevel' => YII_DEBUG ? 3 : 0,
   'targets' => [
       [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning'],
       ],
       [
           'class' => 'yii\log\FileTarget',
           'categories' => ['console'],
           'levels' => ['info', 'error'],
           'logFile' => '##LOG_PATH##',
           'logVars' => [],
       ],
   ],
];
