# Seorules
A package for building seo rules in your Laravel projects. Manage with ease SEO meta tags _(title, description, keywords, noindex)_ of your pages.

## Installation
To install __Seorules__ in Laravel 5.1, simply run `composer require spescina\seorules`.  
To install __Seorules__ in Laravel 4, simply run `composer require spescina\seorules 1.*` and then follow [these](https://github.com/spescina/seorules/blob/v1/README.md) instructions.

Once it's installed, you have to register the service provider. In `app/config/app.php` add the following line of code to the `providers` array  
`Spescina\Seorules\SeorulesServiceProvider::class`.
  
If you want in `app/config/app.php` add the following line of code to the `aliases` array  
`'Seo' => Spescina\Seorules\Facades\Seo::class`.
  
Register the route middleware adding these line to the `app/Http/Kernel.php` file  
`'seorules.before' => \Spescina\Seorules\Init::class`.  

Then, publish the config file with `php artisan vendor:publish --provider="Spescina\Seorules\SeorulesServiceProvider" --tag="config"` .  
Then, publish the migration file with `php artisan vendor:publish --provider="Spescina\Seorules\SeorulesServiceProvider" --tag="migrations"` .  

Then run the migration with `php artisan migrate`.  

## Usage
Define your rules creating entries in the seorules database table
* __alias__: system identificative name of the rule
* __route__: name of the target route
* __pattern__: regular expression for matching page url (used for targeting different pages on the same route)
* __priority__: highest value come first
* __title__: title tag
* __description__: description meta tag
* __keywords__: keywords meta tag
* __noindex__: noindex meta tag

```javascript
{
  alias: 'first',
  route: 'first.route',
  pattern: '',
  priority: 0,
  title: 'the first route title is [#_first_placeholder]',
  description: 'my first route description is [#_second_placeholder]',
  keywords: '[#_first_placeholder], [#_second_placeholder], laravel',
  noindex: 0
},
{
  alias: 'second',
  route: 'second.route',
  pattern: '',
  priority: 0,
  title: 'the second route title is [#_second_placeholder]',
  description: 'my second route description is empty',
  keywords: '[#_first_placeholder]',
  noindex: 1
}
```

Attach `seorules.before` middleware to your target named routes (route groups are reccomended)
```php
Route::group(['middleware' => 'seorules.before'], function()
{
    Route::get('/first', array('as' => 'first.route', function(){
        //do things
    }));

    Route::get('/second', array('as' => 'second.route', function(){
        //do things
    }));
});
```
Manage your rules in your controllers or in your closures
```php
Seo::addPlaceholder('first_placeholder','Foo');
Seo::addPlaceholder('second_placeholder','Bar');
```
Display prepared fields in your views
```php
<title>{{ Seo::get('title') }}</title>
<meta name="description" content="{{ Seo::get('description') }}" />
<meta name="keywords" content="{{ Seo::get('keywords') }}" />
@if (Seo::get('noindex'))
<meta name="robots" content="noindex" />
@endif
```

Now you should have rendered this code when visiting `/first` (assuming both routes are prepared with same placeholder data)
```html
<title>the first route title is Foo</title>
<meta name="description" content="my first route description is Bar" />
<meta name="keywords" content="Foo, Bar, laravel" />
```
and when visting `/second`
```html
<title>the second route title is Bar</title>
<meta name="description" content="my second route description is empty" />
<meta name="keywords" content="Foo" />
<meta name="robots" content="noindex" />
```
