# OpenWeatherMap
Simple class for retrieve current weather.

## Usage
```php
<?php
use FuHsi\OpenWeatherMap\OpenWeatherMap;
use FuHsi\FileCache\FileCache;

require 'vendor/autoload.php';

$cache = new FileCache(array(
    'cacheDir' => __DIR__,
    'lifeTime' => FileCache::HOUR * 3,
    'format' => FileCache::FORMAT_JSON
));

$cityNameKey = 'Warsaw';

$weatherData = $cache->get($cityNameKey, false, function () use ($cityNameKey)
{
    // all below options are default
    $options = array(
        'APPID' => '', // Your API key
        'units' => OpenWeatherMap::UNITS_METRIC,
        'lang' => OpenWeatherMap::LANG_POLISH
    );
    
    $weather = new OpenWeatherMap($options);
    return $weather->getCurrentWeatherByCityName($cityNameKey);
});

var_dump($weatherData);

?>
```
Retrieve weather by City name:
```php
$weatherData = $weather->getCurrentWeatherByCityName('Warsaw');
```
Retrieve weather by City name and Country code:
```php
$weatherData = $weather->getCurrentWeatherByCityName('Warsaw,pl');
```
Retrieve weather by City id (recommended):
```php
$weatherData = $weather->getCurrentWeatherByCityName(756135); 
```
Retrieve image:
```php
echo '<img src="' . OpenWeatherMap::getIconUrl($weatherData->weather[0]->icon) . '" alt="' . $weatherData->weather[0]->description . '">';
```
