<?php
/**
 * Created by Vladimir Hryvinskyy.
 * Site: http://codice.in.ua/
 * Date: 26.12.2016
 * Project: oakcms
 * File name: ApiArticle.php
 */

namespace app\modules\content\controllers\frontend;

use app\components\ApiController;
use app\modules\content\models\ContentArticles;
use app\modules\content\models\ContentCategory;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class ApiArticleController extends ApiController
{

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function actionView($catslug, $slug)
    {
        $categoryModel = ContentCategory::find()->published()
            ->joinWith(['translations'])
            ->andWhere(['{{%content_category_lang}}.slug' => $catslug])
            ->one();

        $model = ContentArticles::find()->published()
            ->joinWith(['translations'])
            ->andWhere(['{{%content_articles_lang}}.slug' => $slug])
            ->one();

        if($model === null || $categoryModel === null) {
            throw new NotFoundHttpException(\Yii::t('system', 'The requested page does not exist.'));
        }

        return $model;
    }

    /**
     * @param string $template
     *
     * @return mixed
     */
    public function actionGetTemplate($template = 'index')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        return $this->renderPartial($template);
    }
}
