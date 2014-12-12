<?php

/**
 * OpenWeatherMap
 * 
 * To access the API you need to sign up for an API key if you are on a free or paid plan.
 * http://openweathermap.org/appid
 *
 * @author      Fu-Hsi
 * @copyright   2014 Fu-Hsi
 * @package     OpenWeatherMap
 * @version     1.0.0
 * @link        https://github.com/fu-hsi/open-weather-map
 * @license     http://opensource.org/licenses/MIT MIT License
 * 
 * <code>
 * $weatherConfig = array(
 *     'APPID' => 'API key',
 *     'dir' => '.';
 *     'units' => OpenWeatherMap::UNITS_METRIC,
 *     'lang' => OpenWeatherMap::LANG_POLISH,
 *     'lifetime' => 10800
 * );
 * 
 * $weather = new OpenWeatherMap($weatherConfig);
 * $weatherData = $weather->getCurrentWeatherByCityName('Warsaw,pl');
 * 
 * var_dump($weatherData);
 * </code>
 */

/**
 *
 * @package OpenWeatherMap
 * @author Fu-Hsi
 * @since 1.0.0
 */
class OpenWeatherMap
{

    const UNITS_INTERNAL = 'internal';

    const UNITS_METRIC = 'metric';

    const UNITS_IMPERIAL = 'imperial';

    const LANG_ENGLISH = 'en';

    const LANG_RUSSIAN = 'ru';

    const LANG_ITALIAN = 'it';

    const LANG_SPANISH = 'es';

    const LANG_UKRAINIAN = 'uk';

    const LANG_GERMAN = 'de';

    const LANG_PORTUGUESE = 'pt';

    const LANG_ROMANIAN = 'ro';

    const LANG_POLISH = 'pl';

    const LANG_FINNISH = 'fi';

    const LANG_DUTCH = 'nl';

    const LANG_FRENCH = 'fr';

    const LANG_BULGARIAN = 'bg';

    const LANG_SWEDISH = 'sv';

    const LANG_CHINESE_TRADITIONAL = 'zh_tw';

    const LANG_CHINESE_SIMPLIFIED = 'zh';

    const LANG_TURKISH = 'tr';

    const LANG_CROATIAN = 'hr';

    const LANG_CATALAN = 'ca';

    const END_POINT = 'http://api.openweathermap.org/data/2.5/weather?%s&lang=%s&units=%s&APPID=%s';

    private $config;

    /**
     *
     * @param array $config            
     */
    public function __construct(array $config = array())
    {
        $this->config = array_merge(array(
            'dir' => '.',
            'units' => self::UNITS_METRIC,
            'lang' => self::LANG_POLISH,
            'lifetime' => 10800
        ), $config);
    }

    /**
     *
     * @see http://openweathermap.org/current
     * @param string $cityName
     *            for example 'Warsaw,pl'
     * @return mixed|boolean
     */
    public function getCurrentWeatherByCityName($cityName)
    {
        $url = sprintf(self::END_POINT, 'q=' . urlencode($cityName), $this->config['lang'], $this->config['units'], $this->config['APPID']);
        return $this->loadData($url);
    }

    /**
     *
     * @see http://openweathermap.org/current
     * @param int $cityId
     *            You can receive city id from getCurrentWeatherByCityName()
     * @return mixed|boolean
     */
    public function getCurrentWeatherByCityId($cityId)
    {
        $url = sprintf(self::END_POINT, 'id=' . intval($cityId), $this->config['lang'], $this->config['units'], $this->config['APPID']);
        return $this->loadData($url);
    }

    /**
     *
     * @param string $url            
     * @return mixed|boolean
     */
    private function loadData($url)
    {
        $fileName = rtrim($this->config['dir'], '/\\') . DIRECTORY_SEPARATOR . md5($url);
        
        if (file_exists($fileName) && time() - filemtime($fileName) < $this->config['lifetime']) {
            if (($data = file_get_contents($fileName)) !== false) {
                return json_decode($data);
            }
        } else {
            if (($data = file_get_contents($url)) !== false) {
                file_put_contents($fileName, $data);
                return json_decode($data);
            } else {
                touch($fileName);
            }
        }
        
        return false;
    }

    /**
     *
     * @see http://openweathermap.org/weather-conditions
     * @param string $iconCode            
     * @return string
     */
    public static function getIconUrl($iconCode)
    {
        return 'http://openweathermap.org/img/w/' . $iconCode . '.png';
    }
}

?>