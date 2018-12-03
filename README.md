# Laravel helpers package

This package allows you to generate helper classes with facades and aliases. Also it provides some helper commands and built in helpers.

Once installed you can do stuff like this:

##Commands
Run config:cache, route:cache, view:cache and helpers:cache at once
```bash
php artisan cache:all
```

Run cache:clear, config:clear, route:clear, view:clear and helpers:clear at once
```bash
php artisan cache:clear-all
```

cache:clear-all alias
```bash
php artisan clear:all
```

Add helpers to cache to get them without filesystem watching
```bash
php artisan helpers:cache
```

Remove helpers from cache
```bash
php artisan helpers:clear
```

Run ide-helper:generate, ide-helper:meta and ide-helper:models --nowrite at once
To run this command you should install barryvdh/laravel-ide-helper and doctrine/dbal first!
```bash
php artisan ide-helper:all
```

Generate helper class with facade in your project
```bash
php artisan make:helper {class}
```

##Traits
###Route key getter
``` php
use BoomDraw\Helpers\Traits\RouteKeyGetter.php
```
Sets route key as id for admin* routes and as slug for other

###Service name getter
``` php
use BoomDraw\Helpers\Traits\ServiceNameGetter.php
```
Adds getServiceName() method to generate service name for helper using classname

###Table name getter
``` php
use BoomDraw\Helpers\Traits\TableNameGetter.php
```
Adds getTableName() method to get model table name
Adds getMorphName() method to get model morph name

##Helpers
### SeoHelper
Adds columns() method that allows fast adding meta_keywords, meta_description and robots columns to table migration

### StrHelper
Adds between, wbetween and utrim methods

###Global methods
str_between, str_wbetween, utrim

## Installation
### Laravel

You can install the package via composer:

``` bash
composer require boomdraw/laravel-helpers
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="BoomDraw\Helpers\HelpersServiceProvider" --tag="config"
```

When published, [the `config/helpers.php` config file](https://github.com/boomdraw/laravel-helpers/blob/master/config/helpers.php) contains:

```php
return [

    /*
     * Path to generate helpers in your app folder
     */
    'path' => 'Helpers',

    /*
     * Dir for facades if you want to store them separately
     * If empty, facades will be generated in path with Facade postfix
     */
    'facade_dir' => null,

    /*
     * Key to store helpers in cache
     */
    'cache_key' => 'helpers_cache',

    /*
     * Writes services to cache automatically
     */
    'force_cache' => false,
];
```

##Todo
Add other seo features

## The MIT License (MIT).

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
