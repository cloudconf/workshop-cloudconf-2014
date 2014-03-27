# AWS & PHP Workshop

## Install and checks

First of all you have to install a base system and check that all works correctly.

```
curl -s http://getcomposer.org/installer | php
php composer.phar install

php check.php
```

If you see the message "All done! Congrats, see you then at CloudConf 2014" you are
ready to our CloudConf 2014 AWS & PHP Workshop!

## The PHP Application

This PHP application do not follow any kind of best practices for web development. We
choose to don't use any kind of framework like: Symfony2, Zend Framework 2 or any other
because those frameworks are too much distracting from the real WorkShop goal. The same
reason is why in this project there is not any ORM for database access or any other
super famous framework.

### The goal

The goal of this WorkShop is to focus on PHP and Amazon Web Services and not how a
framework can interact with Cloud Services (bundles, modules etc). We want to focus
on concepts, you have to bind those concepts to your business activities.

