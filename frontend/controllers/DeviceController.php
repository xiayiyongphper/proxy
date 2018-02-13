<?php

namespace frontend\controllers;

use common\models\LeCustomers;
use service\components\Tools;
use Yii;
use frontend\models\DeviceConfig;
use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DeviceController implements the CRUD actions for DeviceConfig model.
 */
class DeviceController extends Controller
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

    public function getRedisModel(){
		$model = new DynamicModel([
			'isNewRecord',
			'customer_id', 'level',
		]);
		$model->addRule(['customer_id','level'], 'required');
		return $model;
	}

	/**
	 * Lists all DeviceConfig models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => DeviceConfig::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Lists all DeviceConfig models.
	 * @return mixed
	 */
	public function actionIndex_redis()
	{
		$redis = Tools::getRedis();
		$optionArray = $redis->hGetAll('debug_device_table');

		$providerArray = [];

		if($optionArray){
			foreach ($optionArray as $customer_id => $level) {
				$providerArray[$customer_id] = [
					'customer_id'=>$customer_id,
					'level'=>$level,
				];
			}
		}

		$provider = new ArrayDataProvider([
			'allModels' => $providerArray,
			'sort' => [
				'attributes' => ['customer_id', 'level'],
			],
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		//echo print_r($provider->keys);exit;

		return $this->render('index_redis', [
			'dataProvider' => $provider,
		]);
	}

	/**
	 * Displays a single DeviceConfig model.
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
	 * Displays a single DeviceConfig model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView_redis($id)
	{
		//exit;
		return $this->render('view_redis', [
			'model' => $this->findModelRedis($id),
		]);
	}

	/**
	 * Creates a new DeviceConfig model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new DeviceConfig();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Creates a new DeviceConfig model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate_redis()
	{

		$model = $this->getRedisModel();

		if($model->load(Yii::$app->request->post())){
			//echo print_r($model->toArray());exit;
			$redis = Tools::getRedis();
			$redis->hSet('debug_device_table', $model->customer_id, $model->level);
			$model->isNewRecord = false;
			return $this->redirect(['view_redis', 'id' => $model->customer_id]);
		} else {
			$model->isNewRecord = true;
			return $this->render('create_redis', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing DeviceConfig model.
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
	 * Updates an existing DeviceConfig model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate_redis($id)
	{
		$model = $this->findModelRedis($id);

		if($model->load(Yii::$app->request->post())){
			//echo print_r($model->toArray());exit;
			$redis = Tools::getRedis();
			$redis->hSet('debug_device_table', $model->customer_id, $model->level);
			return $this->redirect(['view_redis', 'id' => $model->customer_id]);
		} else {
			return $this->render('update_redis', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing DeviceConfig model.
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
	 * Deletes an existing DeviceConfig model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete_redis($id)
	{
		$redis = Tools::getRedis();
		$redis->hDel('debug_device_table', $id);

		return $this->redirect(['index_redis']);
	}

	/**
	 * Finds the DeviceConfig model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return DeviceConfig the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = DeviceConfig::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	/**
	 * Finds the DeviceConfig model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return DeviceConfig the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModelRedis($id)
	{

		$redis = Tools::getRedis();
		$level = $redis->hGet('debug_device_table', $id);

		if ($level) {
			$model = $this->getRedisModel();
			$model->customer_id = $id;
			$model->level = $level;
			$model->isNewRecord = false;
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}


	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionFind_user_ajax()
	{
		session_start();

		$keyword = Yii::$app->request->get('kwd');

		$customer = LeCustomers::find()
			->select(['entity_id', 'phone', 'username', 'store_name', 'address', 'detail_address'])
			->where(['like', 'phone', $keyword])
			->one();
		if(!$customer){
			$customer = LeCustomers::find()
				->select(['entity_id', 'phone', 'username', 'store_name', 'address', 'detail_address'])
				->where(['like','username', $keyword])
				->one();
		}

		if($customer){
			$code = 0;
			$data = $customer->toArray();
		}else{
			$code = 404;
			$data = [];
		}

		echo json_encode([
			'code'=>$code,
			'data'=>$data,
		]);


	}
}
