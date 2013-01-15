<?php

namespace lib;

use Slim\Http\Request;

class SlimFunctions
{
    const OK_CONTENT    = 200;   // todo correcto y se devuelven datos
    const OK_NO_CONTENT = 204;   // todo correcto pero no se devuelve nada
    const OK_PARTIAL    = 206;   // se envia solo una parte
    const BAD_REQUEST   = 400;   // parámetros incorrectos
    const NOT_FOUND     = 404;   // elemento solicitado no encontrado
    const UNAUTHORIZED  = 401;   // elemento solicitado solo con autenticacion

    /**
     * verifica si una cadena parece un email
     * @param  string  $email
     * @return boolean
     */
    public static function check_email($email)
    {
        return preg_match("|^([\w\.-]{1,64}@[\w\.-]{1,252}\.\w{2,4})$|i", $email);
    }

    /**
     * transforma una cadena en un slug que pueda ser utilizado como url
     * @param  string $text
     * @return string
     */
    public static function slug($text)
    {
        $text = trim(strtolower($text));
        $ret = str_replace(array(
                            ' ','-','(',')','*',
                            'ñ',
                            'á','é','í','ó','ú',
                            'à','è','ì','ò','ù',
                            'ä','ë','ï','ö','ü',
                           ),array(
                            '-','-','-','-','-',
                            'n',
                            'a','e','i','o','u',
                            'a','e','i','o','u',
                            'a','e','i','o','u',
                           ),$text);

        return $ret;
    }

    public static function apiReturnStatus(Slim_Http_Response $response, $status=204)
    {
        $response->status($status);
        $response->send();
    }

    /**
     * envía el json de los datos pasados y manda una respuesta 200
     * @param Slim_Http_Response $response
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
     * genera una contraseña
     * @param  int     $length
     * @param  boolean $repeticiones
     * @return string
     */
    public static function genKey($length = 7, $repeticiones = false)
    {
      $password = "";
      $possible = "0123456789abcdefghijkmnopqrstuvwxyz";

      if (!$repeticiones && ($length>count_chars($possible))) return -1;

      $i = 0;
      while ($i < $length) {
        $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        if ($repeticiones || !strstr($password, $char)) {
          $password .= $char;
          $i++;
        }
      }

      return $password;
    }

    public static function asset($url)
    {
        /** @var $app \Slim\Slim */
        $app = \Slim\Slim::getInstance();
        /** @var $request \Slim\Http\Request */
        $request = $app->request();

        return str_replace("/index.php", "", $request->getRootUri())."/".$url;
    }

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
