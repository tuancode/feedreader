<?php

namespace app\controllers;

use app\models\Category;
use app\models\Feed;
use app\models\FeedSearch;
use app\models\FeedSubscribe;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

/**
 * FeedController implements the CRUD actions for Feed model.
 */
class FeedController extends Controller
{
    /**
     * @var string
     */
    private $pjaxConId = '#feed-listview-pjax';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all Feed models.
     *
     * @param integer $cateId Category Id
     * @return mixed
     */
    public function actionIndex($cateId = null)
    {
        $searchModel = new FeedSearch($cateId);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cateId' => $cateId
        ]);
    }

    /**
     * Creates a new Feed model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $cateId Category Id
     * @return mixed
     */
    public function actionCreate($cateId = null)
    {
        $model = new Feed($cateId);
        $model->setAttribute('pubDate', time());

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return [
                    'forceReload' => $this->pjaxConId,
                    'title'=> "Create new feed",
                    'content'=>'<span class="text-success">Created successful.</span>',
                    'footer'=> Html::button('Close', ['class'=>'btn btn-default pull-right','data-dismiss'=>"modal"])
                ];
            } else {
                return [
                    'title'=> "Create new feed",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close', ['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save', ['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('create', ['model' => $model]);
            }
        }
    }

    /**
     * Updates an existing Feed model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id Feed id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return [
                    'forceReload' => $this->pjaxConId,
                    'title'=> 'Update feed #' . $model->title,
                    'content'=>'<span class="text-success">Updated successful.</span>',
                    'footer'=> Html::button('Close', ['class'=>'btn btn-default pull-right','data-dismiss'=>"modal"])
                ];
            } else {
                 return [
                    'title'=> 'Update feed #' . $model->title,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close', ['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save', ['class'=>'btn btn-primary','type'=>"submit"])
                 ];
            }
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('update', ['model' => $model]);
            }
        }
    }

    /**
     * Delete an existing Feed model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id Feed id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => $this->pjaxConId];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Creat a or multiple new Category and Feed model.
     *
     * @return mixed
     */
    public function actionSubscribe()
    {
        $model = new FeedSubscribe(new Feed());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('subscribe', ['model' => $model]);
        }
    }

    /**
     * Delete an existing Feed Category model.
     *
     * @param integer $id Category id
     * @throws NotFoundHttpException
     * @return yii\web\Response
     */
    public function actionUnsubscribe($id)
    {
        $category = Category::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $category->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Feed model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id Feed id
     * @return Feed the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feed::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
