<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\User;
use common\models\Album;
use common\models\Photo;
use yii\web\Response;
use Yii;

/**
 * Class ApiController
 * @package frontend\controllers
 */
class ApiController extends Controller
{
    /**
     * @return array
     */
    public function actionUsers(): array
    {
        $page = Yii::$app->request->get('page', 0);
        $page = ($page < 1) ? 1 : $page;

        $limit = 2;
        $offset = ($page - 1) * $limit;

        try {
            $result = User::find()
                            ->select('id, first_name, last_name')
                            ->limit($limit)
                            ->offset($offset)
                            ->asArray()
                            ->all();

        } catch (Exception $exception) {
            $result = ['error' => 'somthing wrong, please try later'];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $result;
    }

    /**
     * @return array
     */
    public function actionUserInfo(): array
    {
        $userId = Yii::$app->request->get('id', 0);

        try {
            $result = User::find()
                            ->select('id, first_name, last_name')
                            ->where(['id' => $userId])
                            ->limit(1)
                            ->asArray()
                            ->one();

            if (!empty($result['id'])) {
                $result['albums'] = Album::find()
                                        ->select('id, title')
                                        ->where(['user_id' => $result['id'] ])
                                        ->asArray()
                                        ->all();
            }

        } catch (Exception $exception) {
            $result = ['error' => 'somthing wrong, please try later'];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $result;
    }

    /**
     * @return array
     */
    public function actionAlbums(): array
    {
        $page = Yii::$app->request->get('page', 0);
        $page = ($page < 1) ? 1 : $page;

        $limit = 2;
        $offset = ($page - 1) * $limit;

        try {
            $result = Album::find()
                            ->select('id, title')
                            ->limit($limit)
                            ->offset($offset)
                            ->asArray()
                            ->all();

        } catch (Exception $exception) {
            $result = ['error' => 'somthing wrong, please try later'];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $result;
    }

    /**
     * @return array
     */
    public function actionAlbumInfo(): array
    {
        $userId = Yii::$app->request->get('id', 0);

        try {
            $result = Album::find()
                            ->select('id, title')
                            ->where(['id' => $userId])
                            ->limit(1)
                            ->asArray()
                            ->one();

            if (!empty($result['id'])) {
                $result['photos'] = Photo::find()
                                        ->select('id, title, url')
                                        ->where(['album_id' => $result['id'] ])
                                        ->asArray()
                                        ->all();
            }

        } catch (Exception $exception) {
            $result = ['error' => 'somthing wrong, please try later'];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $result;
    }
}
