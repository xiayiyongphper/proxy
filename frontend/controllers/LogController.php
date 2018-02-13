<?php

namespace frontend\controllers;

use service\components\Tools;
use Yii;
use frontend\models\Log;
use frontend\models\LogSearch;
use yii\data\Sort;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogController implements the CRUD actions for Log model.
 */
class LogController extends Controller
{
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
	 * Lists all Log models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new LogSearch();
		//Yii::$app->request->queryParams['sort']='-id';

		if(!Yii::$app->request->getQueryParam('sort')){
			$params = Yii::$app->request->queryParams;
			$params['sort'] = '-id';
			Yii::$app->request->setQueryParams($params);
		}

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//var_dump(Yii::$app->request->queryParams);exit;
		//$dataProvider->setSort($sort->orders);
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Lists all Log models.
	 * @return mixed
	 */
	public function actionIndex_redis()
	{
		$searchModel = new LogSearch();
		//Yii::$app->request->queryParams['sort']='-id';

		if(!Yii::$app->request->getQueryParam('sort')){
			$params = Yii::$app->request->queryParams;
			$params['sort'] = '-id';
			Yii::$app->request->setQueryParams($params);
		}

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//var_dump(Yii::$app->request->queryParams);exit;
		//$dataProvider->setSort($sort->orders);
		return $this->render('index_redis', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

    /**
     * Displays a single Log model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Log model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Log();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Log model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Log model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	/**
	 * 清空列表
	 * @return mixed
	 */
	public function actionEmpty()
	{
		Log::updateAll(['is_del'=>1]);
		return $this->redirect(['index']);
	}

	/**
	 * 清空列表
	 * @return mixed
	 */
	public function actionEmpty_redis()
	{
		$model = new Log();
		$id = Yii::$app->request->get('id');
		if($id){
			//$model->deleteAll(['customer_id'=>$id]);
			Log::updateAll(['is_del'=>1], ['customer_id'=>$id]);
		}else{
			//$model->deleteAll();
			//Log::updateAll(['is_del'=>1]);
		}
		return $this->redirect(['index_redis', 'LogSearch[customer_id]'=>$id]);
	}

    /**
     * Finds the Log model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Log the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Log::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
