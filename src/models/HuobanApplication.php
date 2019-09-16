<?php

namespace huoban\models;

use huoban\helpers\CurlHttp;


class HuobanApplication
{


    public static function getTicket($expired = 1209600)
    {
        $current_time = time();
        // $application_id = Yii::$app->params['application']['application_id'];
        // $ticket_data   =  Yii::$app->request->cookies->getValue($application_id.'_ticket_data', null);
        
        // if ($ticket_data) {
        //     $ticket_data = json_decode($ticket_data, 1);
        //     if (($current_time - $ticket_data['time']) < $expired) {
        //         return $ticket_data;
        //     }
        // }
        $params = array(
            'application_id'     => 1000307,
            'application_secret' => 'GkCtOwFXsr1Sqsne6TNi0gMmwHZxKqTn9AzLyuEw',
            'expired'            => $expired,
        );

        $ticket_data         = CurlHttp::post('/ticket', $params);
        $ticket_data['time'] = $current_time;

        // $cookies = Yii::$app->response->cookies;
        // $cookies->add(new \yii\web\Cookie(array(
        //     'name'  => 'ticket_data',
        //     'value' => json_encode($ticket_data),
        // )));
        // die('aaa');
        return $ticket_data;
    }

    public static function setTicket($expired = 1209600)
    {
        $res = self::getTicket($expired);
        CurlHttp::setup($res['ticket'], IS_TEST);
        return $res['ticket'];
    }
}