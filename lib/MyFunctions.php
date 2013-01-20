<?php

namespace lib;

use Slim\Http\Request;

/**
 * This is a lib with various functions
 */
class MyFunctions
{
    const OK_CONTENT    = 200;   // all ok and data return
    const OK_NO_CONTENT = 204;   // all ok but no data
    const OK_PARTIAL    = 206;   // only one part is sended
    const BAD_REQUEST   = 400;   // invalid parameters received
    const NOT_FOUND     = 404;   // page not found
    const UNAUTHORIZED  = 401;   // page only authorized

    /**
     * checks is a string seems a valid email
     * 
     * @param  string  $email
     * 
     * @return boolean
     */
    public static function check_email($email)
    {
        return (boolean) preg_match("|^([\w\.-]{1,64}@[\w\.-]{1,252}\.\w{2,4})$|i", $email);
    }

    /**
     * slugify string passed
     * 
     * @param  string $text
     * 
     * @return string
     */
    public static function slug($text)
    {
        $text = trim(strtolower($text));
        $ret = str_replace(array(
                            ' ','_','(',')','*',
                            'ñ','ç',
                            'á','é','í','ó','ú',
                            'à','è','ì','ò','ù',
                            'ä','ë','ï','ö','ü',
                           ),array(
                            '-','-','-','-','-',
                            'n','c',
                            'a','e','i','o','u',
                            'a','e','i','o','u',
                            'a','e','i','o','u',
                           ),$text);

        return $ret;
    }

    /**
     * Sends reponse passed and status(default 204) to browser
     *
     * @param Slim_Http_Response $response
     *
     * @param int $status
     */
    public static function apiReturnStatus(Slim_Http_Response $response, $status=204)
    {
        $response->status($status);
        $response->send();
    }

    /**
     * sends data json encoded and 200 as default response code
     *
     * @param Slim_Http_Response $response
     *
     * @param mixed              $data
     */
    public static function jsonDataAnd200(Slim_Http_Response $response, array $data, $status = self::OK_CONTENT)
    {
        $response->header("Content-type","application/json");
        print(json_encode($data));
        self::apiReturnStatus($response, $status);
        //$response->send();
    }

    /**
     * generates a key
     * 
     * @param  int     $length
     * @param  boolean $repetitions
     * 
     * @return string
     */
    public static function genKey($length = 7, $repetitions = false)
    {
      $password = "";
      $possible = "0123456789abcdefghijkmnopqrstuvwxyz";

      if (!$repetitions && ($length>count_chars($possible))) return -1;

      $i = 0;
      while ($i < $length) {
        $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        if ($repetitions || !strstr($password, $char)) {
          $password .= $char;
          $i++;
        }
      }

      return $password;
    }

    /**
     * like asset symfony
     *
     * @param $url
     *
     * @return string
     */
    public static function asset($url)
    {
        /** @var $app \Slim\Slim */
        $app = \Slim\Slim::getInstance();
        /** @var $request \Slim\Http\Request */
        $request = $app->request();

        return str_replace("/index.php", "", $request->getRootUri())."/".$url;
    }

    /**
     * Returns a $key $_SESSION value
     *
     * @param $key
     *
     * @return mixed
     */
    public static function session($key)
    {
        if (isset($_SESSION[$key])) {

            return $_SESSION[$key];
        }

    }

    /**
     * Converts underscored identifier to CamelCase
     *
     * @param string $str
     * @return string
     */
    public static function underscoredToCamelCaseEntityName($str)
    {
        $array = explode("_",$str);
        $result = "";
        foreach ($array as $item) {
            $result .= ucfirst($item) . ($result?'':'\\');
        }
        return $result;
    }

    /**
     * Converts camelCase identifier to underscored
     *
     * @param $str
     * @return string
     */
    public static function camelCaseToUnderscored($str)
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1_', $str));
    }

}
