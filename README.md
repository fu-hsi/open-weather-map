open-weather-map
================

Simple class for retrieve current weather.

Setup
-----
```php
include 'OpenWeatherMap.php';

// all below settings are default
$weatherConfig = array(
    'APPID' => '', // Your API key
    'dir' => '.';
    'units' => OpenWeatherMap::UNITS_METRIC,
    'lang' => OpenWeatherMap::LANG_POLISH,
    'lifetime' => 10800 // Cache data for 3 hours
);

$weather = new OpenWeatherMap($weatherConfig);
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
Dump data:
```php
var_dump($weatherData);
```
Retrieve image:
```php
echo '<img src="' . OpenWeatherMap::getIconUrl($weatherData->weather[0]->icon) . '" alt="' . $weatherData->weather[0]->description . '">';
```
