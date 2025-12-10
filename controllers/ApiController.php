<?php

declare(strict_types=1);

namespace app\controllers;

use yii\rest\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Forceer JSON response
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        return $behaviors;
    }

    /**
     * GET /api/hello
     */
    public function actionHello($name = 'visitor')
    {
        return [
            'status' => 'success',
            'message' => "Hello $name!",
            'time' => date('Y-m-d H:i:s'),
        ];
    }
}
