<?php

namespace Zhaohangyang\Curl;

class Curl
{
    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';
    const HTTP_METHOD_PUT = 'PUT';
    const HTTP_METHOD_DELETE = 'DELETE';

    static  $ch, $headers;
    public static function setup()
    {


        self::$ch = curl_init();
        // 获取的信息以文件流的形式返回，而不是直接输出
        curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
        // 禁用后cURL将终止从服务端进行验证。使用CURLOPT_CAINFO选项设置证书使用CURLOPT_CAPATH选项设置证书目录 
        // 如果CURLOPT_SSL_VERIFYPEER(默认值为2)被启用，CURLOPT_SSL_VERIFYHOST需要被设置成TRUE否则设置为FALSE。
        curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, false);
        // 1 检查服务器SSL证书中是否存在一个公用名(common name)。译者注：公用名(Common Name)一般来讲就是填写你将要
        // 申请SSL证书的域名 (domain)或子域名(sub domain)。2 检查公用名是否存在，并且是否与提供的主机名匹配。
        curl_setopt(self::$ch, CURLOPT_SSL_VERIFYHOST, false);
        // 启用时会将头文件的信息作为数据流输出。
        curl_setopt(self::$ch, CURLOPT_HEADER, true);
        // 启用时追踪句柄的请求字符串。
        curl_setopt(self::$ch, CURLINFO_HEADER_OUT, true);
    }

    public static function request($method, $url, $attributes = array(), $options = array())
    {
        self::setup();

        switch ($method) {
            case self::HTTP_METHOD_GET:
                self::$headers['Content-type'] = 'application/x-www-form-urlencoded';
                if ($attributes) {
                    $query = self::encodeAttributes($attributes);
                    $url = $url . '?' . $query;
                }
                break;
            case self::HTTP_METHOD_DELETE:
                self::$headers['Content-type'] = 'application/x-www-form-urlencoded';
                if ($attributes) {
                    $query = self::encodeAttributes($attributes);
                    $url = $url . '?' . $query;
                }
                break;
            case self::HTTP_METHOD_POST:
                if (isset($options['upload']) && $options['upload']) {
                    self::$headers['Content-type'] = 'multipart/form-data';
                    // php5.6之后的只能使用这个方法
                    foreach ($attributes['files'] as $file) {
                        $attributes[$file['name']] = curl_file_create($file['source'], '', $file['name']);
                    }
                    unset($attributes['files']);
                    curl_setopt(self::$ch, CURLOPT_POST, TRUE);
                    curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $attributes);
                } else {
                    self::$headers['Content-type'] = 'application/json';
                    curl_setopt(self::$ch, CURLOPT_POST, TRUE);
                    $encoded_attributes = json_encode($attributes);
                    curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $encoded_attributes);
                }
                break;
            case self::HTTP_METHOD_PUT:
                $encoded_attributes = json_encode($attributes);
                curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $encoded_attributes);
                self::$headers['Content-type'] = 'application/json';
                break;
        }

        // 设置头部信息
        if (isset($options['headers']) && $options['headers']) {
            foreach ($options['headers'] as $key => $value) {
                self::$headers[$key] = $value;
            }
        }
        curl_setopt(self::$ch, CURLOPT_HTTPHEADER, self::curlHeaders(self::$headers));

        // 规范设置url信息
        if (substr($url, 0, 4) == 'http' || substr($url, 0, 5) == 'https') {
            $request_url = $url;
        } else {
            $request_url = 'http://' . $url;
        }
        curl_setopt(self::$ch, CURLOPT_URL, $request_url);

        // 执行信息
        $raw_response = curl_exec(self::$ch);
        var_dump($raw_response);

        // 获取最后一次传输的相关信息。header大小
        $raw_headers_size = curl_getinfo(self::$ch, CURLINFO_HEADER_SIZE);
        // 释放资源
        curl_close(self::$ch);

        // 获取body 信息
        $response_content = substr($raw_response, $raw_headers_size);
        if ($response_content === false) {
            $response_content = '';
        }
        // 获取headers 信息
        $response_headers = substr($raw_response, 0, $raw_headers_size);
        $response_headers = self::parseHeaders($response_headers);
        // 关闭cURL资源，并且释放系统资源
        $body = json_decode($response_content, true, 512, JSON_BIGINT_AS_STRING);
        return $body;
    }


    public static function get($url, $attributes = array(), $options = array())
    {
        return self::request(self::HTTP_METHOD_GET, $url, $attributes, $options);
    }

    public static function post($url, $attributes = array(), $options = array())
    {
        return self::request(self::HTTP_METHOD_POST, $url, $attributes, $options);
    }

    public static function put($url, $attributes = array(), $options = array())
    {
        return self::request(self::HTTP_METHOD_PUT, $url, $attributes, $options);
    }

    public static function delete($url, $attributes = array())
    {
        return self::request(self::HTTP_METHOD_DELETE, $url, $attributes);
    }


    public static function curlHeaders($curl_headers)
    {
        $headers = array();
        foreach ($curl_headers as $header => $value) {
            $headers[] = "{$header}: {$value}";
        }
        return $headers;
    }

    public static function encodeAttributes($attributes)
    {

        $result = '';
        if (is_array($attributes)) {
            $result = http_build_query($attributes, '', '&');
        }

        return $result;
    }
    public static function parseHeaders($headers)
    {
        $list = array();
        $headers = str_replace("\r", '', $headers);
        $headers = explode("\n", $headers);
        foreach ($headers as $header) {
            if (strstr($header, ':')) {
                $name = strtolower(substr($header, 0, strpos($header, ':')));
                $list[$name] = trim(substr($header, strpos($header, ':') + 1));
            }
        }
        return $list;
    }
}
