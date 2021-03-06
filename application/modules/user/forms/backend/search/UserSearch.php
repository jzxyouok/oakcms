<?php

namespace app\modules\user\forms\backend\search;

use app\modules\user\Module;
use app\modules\user\models\backend\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `app\modules\user\models\backend\User`.
 */
class UserSearch extends Model
{
    public $id;
    public $username;
    public $email;
    public $status;
    public $role;
    public $date_from;
    public $date_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email', 'role'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => \Yii::t('user', 'USER_CREATED'),
            'updated_at' => \Yii::t('user', 'USER_UPDATED'),
            'username' => \Yii::t('user', 'USER_USERNAME'),
            'email' => \Yii::t('user', 'USER_EMAIL'),
            'status' => \Yii::t('user', 'USER_STATUS'),
            'date_from' => \Yii::t('user', 'USER_DATE_FROM'),
            'date_to' => \Yii::t('user', 'USER_DATE_TO'),
        ];
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'role' => $this->role,
        ]);

        $query
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }
}
