<?php

namespace Huoban\Models;

use Huoban\Helpers\CurlHttp;


class HuobanApplication
{
    public static function getEnterpriseTicket($application_id, $application_secret, $expired = 1209600)
    {
        $params = array(
            'application_id'     => $application_id,
            'application_secret' => $application_secret,
            'expired'            => $expired,
        );

        $ticket_data         = CurlHttp::post('/ticket', $params);
        return $ticket_data['ticket'];
    }

    public static function getTableTicket($expired = 1209600)
    {
        $ticket = $_GET['ticket'] ?  $_GET['ticket'] : $_COOKIE["ticket"];
        setcookie("ticket", $ticket, $expired);
    }

    public static function setTicket($ticket)
    {
        CurlHttp::setup($ticket, IS_TEST);
    }
}
