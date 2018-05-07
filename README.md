Imaginator
==========

### This package is not finished yet

This package adds an easy to use and secure way of providing scaled images.

Current version can only be used with laravel, but there are plans to make it framework agnostic in the future.



Installation
------------

Install using composer:

```
composer require hubertnnn/imaginator
```

Then publish laravel config file:

```
php artisan vendor:publish --provider="HubertNNN\Imaginator\Integration\Laravel\ImaginatorServiceProvider" --tag="config"
```

For laravel versions below 5.5 you need to register the provider and facade.
To do so add the ServiceProvider to the providers array in `config/app.php`:

```
HubertNNN\Imaginator\Integration\Laravel\ImaginatorServiceProvider::class,
```

and Facade to the facades array in the same file

```
'Imaginator' => HubertNNN\Imaginator\Integration\Laravel\ImaginatorFacade::class,
```


Configuration
-------------

All configuration is done using `config/imaginator.php` file.
Each option is documented inside the file.

Basic configuration requires you to setup providers and formats.
The default file contains example configuration.



Usage
-----

You can create an image link using following commands:
```
Imaginator::entity($entity, $format, $optionalEntityType);
Imaginator::image($type, $instance, $format);
```

For example:
```
$user = User::first();
echo Imaginator::entity($user, '800x600');
```

If single entity provides more than 1 image (eg. user can have an avatar and a picture),
you can use the optional parameter to choose what image are you interested in.
Here is an example of usage in blade view.
```
<img src="{{ Imaginator::entity($user, '800x600', 'avatar') }}">
```

