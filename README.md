
![GitHub tag (latest by date)](https://img.shields.io/github/v/tag/Fabricio872/random-message-bundle)
![GitHub last commit](https://img.shields.io/github/last-commit/Fabricio872/random-message-bundle)
![Packagist Downloads](https://img.shields.io/packagist/dt/Fabricio872/random-message-bundle)
![GitHub Repo stars](https://img.shields.io/github/stars/Fabricio872/random-message-bundle?style=social)

# Random messages 

Symfony bundle that gives you various funny messages you can display on loading screen or anywhere where you need some placeholder content

Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require fabricio872/random-message-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require fabricio872/random-message-bundle
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

# Default configuration for extension with alias: "random_message"
random_message:

 # Define default path where list of messages will be stored.
 path:                 '%kernel.project_dir%/var/random_messages'

 # List of repositories for messages
 repositories:

  # Default:
  - https://github.com/Fabricio872/random-message-repository

 # Define default language.
 default_language:     en

 # Define your email with which commits with messages will be done.
 git_email:            anonym@email.com

 # Define your name with which commits with messages will be done
 git_name:             anonym

 # Access token generated by GitHub you can make one here (https://github.com/settings/tokens)
 git_access_token:     accessToken

# ...
```

# Usage

First of all we need to pull messages from message repository. To do that execute this command: ```bin/console random_message:pull```
this command will go through all configured repositories and will try to download or update them.

 > note: it might come useful to include this command to be executed every time you do **composer install** or **composer update**
 > to do that in your composer.json look for ```"scripts"``` and in ```"auto-scripts"``` add under ```"cache:clear": "symfony-cmd"```
 > new line with ```"random_message:pull": "symfony-cmd"```,

For receiving random message you can use Dependency injection inside your controller
```php
// src/Controller/SomeController.php

    // ...

    #[Route('/some_path', 'some_name')]
    public function some_name(RandomMessage $randomMessage)
    {
        $message = $randomMessage->getMessage();
        
        return $this->render('some-view.html.twig', [
            'randomMessage'=> $message
        ]);
    }
    
    // ...
```

or it can be used directly inside your template:

```twig
{# some Twig template #}

    {# ... #}

    {{ random_messge() }}

    {# ... #}
```
 
# Contributing

You can create your own messages or even contribute them for all to enjoy

## Creating and configuring repository


For creating new messages you need to have new empty git repository for example on GitHub
and add **https** link to your list of repositories like shown bellow:

```yaml
# config/services.yaml

# ...

# Default configuration for extension with alias: "random_message"
random_message:

 # Define default path where list of messages will be stored.
 path:                 '%kernel.project_dir%/var/random_messages'

 # List of repositories for messages
 repositories:

  # Default:
  - https://github.com/Fabricio872/random-message-repository

 # Define default language.
 default_language:     en

 # Define your email with which commits with messages will be done.
 git_email:            anonym@email.com

 # Define your name with which commits with messages will be done
 git_name:             anonym

 # Access token generated by GitHub you can make one here (https://github.com/settings/tokens)
 git_access_token:     accessToken

# ...
```
> note: repolace <YOUR_NAME> and <YOUR_REPO> with your actual values

 - Then update **git_email** and **git_name** with your actual git name and email used with repo you just added.
 - To generate **git_access_token** go to this page: [https://github.com/settings/tokens](https://github.com/settings/tokens) and create token with access to pushing commits

## Creating new messages

Ok so about creating new repo for your messages well... it is not necessary I was lying you can totally create messages to default repo, but you wouldn't be able to download them on deployment server.  
Well since you have an empty repo why not just use it.

 - type command ```bin/console random_message:create``` this will ask you what repo you want to use so pick newly created one
 - then it will ask you the ```category``` for your messages and ```language``` the messages will be written in.
 > note: For language use 2 letter format for example for english use ```en```
 - then you can add as many messages as you want.
 - if you want to end adding new messages just press ```enter``` again with empty message

## Pushing messages

So we have an empty repo and json file with new messages it is time to actually push them to Github. 

 - Assuming we have correctly configured git_name and git_access_token.
execute command ```bin/console random_message:push``` this command will ask you what repo you want to push to so pick the newly created one.

 - Then it will show you changes you made to the repo there should be list with all json files you just created. If you are OK with changes type "y" and press ```enter```
 - Now you can type your commit message. Type here something meaningful about your messages like source or something and again press ```enter```
 - Hopefully everything is working and you will see green message telling you that repository was successfully updated, and you can check new commit in your GitHub page. 

## Contributing messages to mainline repo

If you want to share your messages with whole world do same thing as you did on step: 
**Creating and configuring repository** but don't create new empty repository but fork this: 
```https://github.com/Fabricio872/random-message-repository``` instead.
And then continue as with empty repository.

> note: To fork a repo on GitHub go to repository you want to fork and click on **Fork** button on top right corner.
