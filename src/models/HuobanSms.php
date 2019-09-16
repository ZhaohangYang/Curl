<?php
namespace huoban\models;


use app\module\sms\TopClient;
use app\module\sms\AlibabaAliqinFcSmsNumSendRequest;

class HuobanSms {
    
    /**
    * 发送短信
    * @date         2016/11/21
    * @param    $opt    array
    * @param    $type   string
    */
    public static function send($opt = array(), $type = '') {
        
        //配置数据
        $app_key = Yii::$app->params['sms_info']['app_key'];
        $secret_key = Yii::$app->params['sms_info']['secret_key'];  
        $sign_name = Yii::$app->params['sms_info']['sign_name'];
        
        //使用系统模板
        $c = new TopClient($app_key, $secret_key);
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req ->setExtend( '' );
        $req ->setSmsType( 'normal' );
        $req ->setSmsFreeSignName( $sign_name );
        
        switch($type) {
            case 'verify':                
                $req ->setSmsParam( '{code:"'.$opt['verify'].'",product:"'.$sign_name.'"}' );
                $req ->setSmsTemplateCode( 'SMS_36200026' );//身份校验
                break;
            case 'duizhang':
                $req ->setSmsParam( '{name:"'.$opt['name'].'",sname:"'.$opt['sname'].'",mob:"'.$opt['mob'].'",bname:"'.$opt['bname'].'"}' );
                $req ->setSmsTemplateCode( 'SMS_62500523' );//队长接单
                break;
            case 'siji':
                $req ->setSmsParam( '{name:"'.$opt['name'].'",sname:"'.$opt['sname'].'",mob:"'.$opt['mob'].'",bname:"'.$opt['bname'].'",bbname:"'.$opt['bname'].'"}' );
                $req ->setSmsTemplateCode( 'SMS_62460600' );//司机接单
                break;    
            case 'complete':
                $req ->setSmsParam( '{name:"'.$opt['name'].'"}' );
                $req ->setSmsTemplateCode( 'SMS_50780006' );//行程结束
                break;
        }
        
        $req ->setRecNum( $opt['phone'] );
        $resp = $c ->execute( $req );

        if($resp->result->err_code == 0 && $resp->result->success == 'true') {            
            return true;
        }
        
        return false;
    }
}