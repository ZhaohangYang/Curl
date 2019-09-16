<?php

namespace huoban\models;

use huoban\helpers\Curl_http;
use yii;

class HuobanApplication
{

    public static function get_ticket($expired = 1209600)
    {
        $currentTime = time();
        $applicationId = Yii::$app->params['application']['applicationId'];
        $ticketData   =  Yii::$app->request->cookies->getValue($applicationId.'_ticketData', null);
        
        if ($ticketData) {
            $ticketData = json_decode($ticketData, 1);
            if (($currentTime - $ticketData['time']) < $expired) {
                return $ticketData;
            }
        }
        $params = array(
            'application_id'     => Yii::$app->params['application']['applicationId'],
            'application_secret' => Yii::$app->params['application']['applicationSecret'],
            'expired'            => $expired,
        );
        $ticketData         = Curl_http::post('/ticket', $params);
        $ticketData['time'] = $currentTime;

        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie(array(
            'name'  => 'ticketData',
            'value' => json_encode($ticketData),
        )));
        return $ticketData;
    }

    public static function set_ticket($expired = 1209600)
    {
        $res = self::get_ticket($expired);
        Curl_http::setup($res['ticket'], IS_TEST);
        return $res['ticket'];
    }
}