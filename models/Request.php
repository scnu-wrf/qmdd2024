<?php
//请求类
class Request {
    //GET
    /**
 * CURL-get请求
 * @param string $url 请求的url
 * @param array $param 请求的参数
 * @param string $output 输出格式
 * @param int $timeout 超时时间
 * @return mixed 数组形式
 */

    public static function do_curl_get_request($url = '', $param = [],$output = 'json', $timeout = 10){
        $ch = curl_init();
        if (is_array($param)) {
            $url = $url . '?' . http_build_query($param);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); // 允许 cURL 函数执行的最长秒数
        $data = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($data , true);
        return $json;
    }
    //POST
    /**
 * CURL-post请求
 * @param string $url 请求的url地址
 * @param array $param 请求的参数
 * @param array $header
 * @param string $output 输出格式
 * @param int $timeout 超时时间
 * @return mixed
 */
    public static function do_curl_post_request($url = '', $param = [], $header = [], $output = 'json',$timeout = 100){
        $ch = curl_init();
        if (is_array($param)) {
            $urlparam = http_build_query($param);
        } else if (is_string($param)) { //json字符串
        $urlparam = $param;
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); //设置超时时间
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //返回原生的（Raw）输出
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1); //POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $urlparam); //post数据
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $data = curl_exec($ch);
        curl_close($ch);
        if ($output == 'json') {
            $json = json_decode($data , true);
            return $json ;
        } else {
            return $data ;
        }
    }

}