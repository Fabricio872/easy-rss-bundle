
![GitHub tag (latest by date)](https://img.shields.io/github/v/tag/Fabricio872/easy-rss-bundle)
![GitHub last commit](https://img.shields.io/github/last-commit/Fabricio872/easy-rss-bundle)
![Packagist Downloads](https://img.shields.io/packagist/dt/Fabricio872/easy-rss-bundle)
![GitHub Repo stars](https://img.shields.io/github/stars/Fabricio872/easy-rss-bundle?style=social)

# Easy RSS

Symfony bundle for managing RSS feed just add items and set limits and bundle handles storing items and deleting old ones automatically.

Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require fabricio872/easy-rss-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require fabricio872/easy-rss-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php
return [
    // ...
    Fabricio872\RandomMessageBundle\EasyRssBundle::class => ['all' => true],
];
```

## Configuration options
```yaml
# config/services.yaml

# ...

# Default configuration for extension with alias: "easy_rss"
easy_rss:

 # Maximum feeds that would be stored. (0 to unlimited)
 max_feeds:            10

# ...
```

## Usage

### First of all we need to create an endpoint on which we can connect RSS reader:

```php
// src/Controller/RssController.php

//...

    #[Route('/rss.xml', name: 'app_rss_feed')]
    public function index(EasyRss $easyRss): Response
    {
        return $easyRss->getResponse('Title for RSS feed');
    }
    
//...

```

### Then you can start adding feeds:

 - create Feed object:

```php
// src/any-place-in-your-project

//...

    $feed = new \Fabricio872\EasyRssBundle\DTO\Feed();
    $feed->setTitle('My first post');
    $feed->setDescription('This is my first post.');

//...

```
 - publish feed:

```php
// src/any-place-in-your-project

//...

    public function someMethodWithDependencyInjection(\Fabricio872\EasyRssBundle\EasyRss $easyRss)
    {
        $easyRss->setMaxFeeds(); // OPTIONAL this option is override for what you have set in config
        
        $easyRss->add($feed); // this will put your feed to DB and remove old feeds if there are more than MaxFeeds
    }

//...

```

And that's it if your page has only one RSS feed channel than you are done.

## More than one RSS channel

### create more endpoints for each channel

```php
// src/Controller/RssController.php

//...

    #[Route('/rss_one.xml', name: 'app_rss_one_feed')]
    public function rss_one(EasyRss $easyRss): Response
    {
        return $easyRss->getResponse('Title for first RSS feed', 'first'); // second parameter is channel identifier
    }

    #[Route('/rss_two.xml', name: 'app_rss_two_feed')]
    public function rss_two(EasyRss $easyRss): Response
    {
        return $easyRss->getResponse('Title for second RSS feed', 'second'); // second parameter is channel identifier
    }
    
//...

```

### create feed with defined channel


```php
// src/any-place-in-your-project

//...

    $feed = new \Fabricio872\EasyRssBundle\DTO\Feed();
    $feed->setTitle('My first post');
    $feed->setChannel('first'); // name of the channel has to be same as defined in controller
    $feed->setDescription('This is my first post.');

//...

```

> adding feed with defined channel is same as shown above.
