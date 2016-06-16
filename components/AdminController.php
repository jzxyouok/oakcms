<?php
/**
 * Created by Vladimir Hryvinskyy.
 * Site: http://codice.in.ua/
 * Date: 14.05.2016
 * Project: oakcms
 * File name: AdminController.php
 */

namespace app\components;

use app\modules\language\models\Language;
use Yii;
use yii\web\Controller;

class AdminController extends Controller
{

    public $error = null;
    public $_languages = NULL;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        // Ініт мови сайту
        $this->_languages = Language::find()->where(['language_id' => Yii::$app->language])->asArray()->one();
        Yii::$app->session->set('_languages', $this->_languages);
    }

    protected static function getDefaultLanguage($lang = false) {
        if($lang === false) {
            $lang = Language::findOne(Yii::$app->language);
        } else {
            $lang = Language::getLangByUrl($lang);
        }
        return $lang;
    }

    /**
     * Write in sessions alert messages
     * @param string $type error or success
     * @param string $message alert body
     */
    public function flash($type, $message)
    {
        Yii::$app->getSession()->setFlash($type == 'error' ? 'danger' : $type, $message);
    }

    public function back()
    {
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Formats response depending on request type (ajax or not)
     * @param string $success
     * @param bool $back go back or refresh
     * @return mixed $result array if request is ajax.
     */
    public function formatResponse($success = '', $back = true)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($this->error) {
                return ['result' => 'error', 'error' => $this->error];
            } else {
                $response = ['result' => 'success'];
                if ($success) {
                    if (is_array($success)) {
                        $response = array_merge(['result' => 'success'], $success);
                    } else {
                        $response = array_merge(['result' => 'success'], ['message' => $success]);
                    }
                }
                return $response;
            }
        } else {
            if ($this->error) {
                $this->flash('error', $this->error);
            } else {
                if (is_array($success) && isset($success['message'])) {
                    $this->flash('success', $success['message']);
                } elseif (is_string($success)) {
                    $this->flash('success', $success);
                }
            }
            return $back ? $this->back() : $this->refresh();
        }
    }
}