<?php

namespace frontend\models;

use service\components\Tools;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Log;

/**
 * LogSearch represents the model behind the search form about `frontend\models\Log`.
 */
class LogSearch extends Log
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['customer_id', 'device_id', 'route', 'client', 'api_remote', 'charles', 'proxy_show', 'request', 'response_code', 'response'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Log::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['!=', 'is_del', 1])
			->andFilterWhere(['like', 'customer_id', $this->customer_id])
			->andFilterWhere(['like', 'device_id', $this->device_id])
            ->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'client', $this->client])
            ->andFilterWhere(['like', 'api_remote', $this->api_remote])
            ->andFilterWhere(['like', 'charles', $this->charles])
            ->andFilterWhere(['like', 'proxy_show', $this->proxy_show])
            ->andFilterWhere(['like', 'request', $this->request])
			->andFilterWhere(['like', 'response_code', $this->response_code])
			->andFilterWhere(['like', 'response', $this->response]);

		Tools::log($query->createCommand()->getRawSql(),'test.log');

        return $dataProvider;
    }
}
