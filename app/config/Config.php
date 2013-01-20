<?php


namespace app\config;


class Config
{

    private static $instance = null;

    private $languages;

    private $languageCodes;

    public function __construct()
    {
        if (defined('LANGUAGES')){
            $this->languages = unserialize(LANGUAGES);
        } else {
            $this->languages = array('en' => _('English'));
        }
        $this->languageCodes = array();
        foreach ($this->languages as $code=>$lang) {
            $this->languageCodes[] = $code;
        }

        // Bind a domain to directory
        // Gettext uses domains to know what directories to
        // search for translations to messages passed to gettext
        $folder = dirname(dirname(dirname(__FILE__))).'/resources/i18n/';
        bindtextdomain('default', $folder);
        //die($folder);
        // Set the current domain that gettext will use
        textdomain ('default');

        $langs = array (
            'es' => 'ES',
            'en' => 'GB',
            'ca' => 'ES',
        );

        $code = isset($_SESSION['lang'])?$_SESSION['lang']:'en';

        if (isset($langs[$code]))
            $iso_code = $code.'_'.$langs[$code];
        else{
            $code     = "en";
            $iso_code = 'en_GB';
        }

        // Set the LANGUAGE environment variable to the desired language
        putenv ('LANGUAGE='.$iso_code);
        putenv ("LC_ALL=$iso_code");
        setlocale(LC_ALL, $iso_code);
    }

    /**
     * Get instance of Config
     *
     * @return Config
     */
    public static function getInstance()
    {
        if ( null === self::$instance )
        {
            self::$instance = new Config();
        }
        return self::$instance;
    }

    /**
     * Get languages
     *
     * @return array
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Get languages
     *
     * @return array
     */
    public static function languages()
    {
        $config = self::getInstance();
        return $config->getLanguages();
    }

    /**
     * Get language codes
     *
     * @return array
     */
    public function getLanguageCodes()
    {
        return $this->languageCodes;
    }

    /**
     * Get language codes
     *
     * @return array
     */
    public static function languageCodes()
    {
        $config = self::getInstance();
        return $config->getLanguageCodes();
    }

}