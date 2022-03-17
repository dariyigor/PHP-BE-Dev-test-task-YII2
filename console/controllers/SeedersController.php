<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\User;
use common\models\Album;
use common\models\Photo;
use Exception;

/**
 * Class SeedersController
 * @package console\controllers
 */
class SeedersController extends Controller {

    public function actionCreateDemoUsers() {

        for ($pos = 1; $pos <= 10; ++$pos) {

            $user = User::findOne(['username' => 'user_' . $pos]);
            if ($user) {
                echo "username " . $user->username . " already exist" . PHP_EOL;
                continue;
            }

            $user = new User;
            $user->email = 'testuser' . $pos . '@test.com';
            $user->setPassword('pass' . $pos);
            $user->username = 'user_' . $pos;
            $user->status = 10;
            $user->first_name = 'first_name_' . $pos;
            $user->last_name = 'last_name_' . $pos;
            $user->save();

            if ($user->hasErrors()) {
                throw new Exception(PHP_EOL . implode(PHP_EOL, array_column($user->errors, 0)) . PHP_EOL);
            }

            echo "username " . $user->username . " was created" . PHP_EOL;
        }
    }

    public function actionCreateDemoAlbums() {

        $userMaxId = 0;
        $albumCounter = 1;

        do {
            $usersList = User::find()
                            ->select('id')
                            ->where('id > ' . $userMaxId)
                            ->orderBy('id')
                            ->limit(2)
                            ->asArray()
                            ->all();

            if (empty($usersList)) {
                break;
            }

            foreach ($usersList as $userData) {

                $userMaxId = $userData['id'];

                $album = Album::findOne(['user_id' => $userData['id'] ]);
                if ($album) {
                    echo "album for user_id {$userData['id']} already exist" . PHP_EOL;
                    continue;
                }

                for ($pos = 1; $pos <= 10; ++$pos) {
                    $album = new Album;
                    $album->user_id = $userData['id'];
                    $album->title = 'album_' . $albumCounter;
                    $album->save();

                    if ($album->hasErrors()) {
                        throw new Exception(PHP_EOL . implode(PHP_EOL, array_column($album->errors, 0)) . PHP_EOL);
                    }

                    echo "album " . $album->title . " for user_id {$userData['id']} was created" . PHP_EOL;

                    $albumCounter++;
                }

                echo PHP_EOL;
            }

        } while (!empty($usersList[0]));
    }

    public function actionCreateDemoPhotos() {

        $albumMaxId = 0;
        $photoCounter = 1;

        do {
            $albumsList = Album::find()
                            ->select('id')
                            ->where('id > ' . $albumMaxId)
                            ->orderBy('id')
                            ->limit(2)
                            ->asArray()
                            ->all();

            if (empty($albumsList)) {
                break;
            }

            foreach ($albumsList as $albumData) {

                $albumMaxId = $albumData['id'];

                $photo = Photo::findOne(['album_id' => $albumData['id'] ]);
                if ($photo) {
                    echo "photo for album_id {$albumData['id']} already exist" . PHP_EOL;
                    continue;
                }

                for ($pos = 1; $pos <= 10; ++$pos) {
                    $photo = new Photo;
                    $photo->album_id = $albumData['id'];
                    $photo->title = 'photo_' . $photoCounter;
                    $photo->url = '/photo/' . $albumData['id'] . '_photo_' . $pos . '.png';
                    $photo->save();

                    if ($photo->hasErrors()) {
                        throw new Exception(PHP_EOL . implode(PHP_EOL, array_column($photo->errors, 0)) . PHP_EOL);
                    }

                    echo "photo " . $photo->title . " for album_id {$albumData['id']} was created" . PHP_EOL;

                    $photoCounter++;
                }

                echo PHP_EOL;
            }

        } while (!empty($albumsList[0]));
    }
}
