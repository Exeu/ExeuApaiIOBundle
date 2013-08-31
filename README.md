ExeuApaiIOBundle
==============

Symfony 2 integration of the ApaiIO-library.

Installation
---------

All you have to do is to add the following lines to your composer.json:

```js
{
    "require": {
        "exeu/apai-io-bundle": "dev-master"
    }
}
```

After you've done this tell composer to update your vendors:

```bash
$ php composer.phar update exeu/apai-io-bundle
```

Finally register the new Bundle with your application:

```php
<?php

// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new Exeu\ApaiIOBundle\ExeuApaiIOBundle(),
    // ...
);
```

Minimal configuration
---------

To get this bundle working you have to add the following to your config.yml

```yaml
# app/config/config.yml

exeu_apai_io:
    accesskey: YOUR ACCESSKEY
    secretkey: YOUR SECRETKEY
    associatetag: YOUR ASSOCIATE TAG
    country: COUNTRY (eg. de, com)
```

Usage
---------

To work with ApaiIO you need to get the new service for example in your controller:

``` php
<?php

$apaiIo = $this->get('apaiio');

```

Now you can execute your first searchrequest:

``` php
<?php

// ...
$search = new \ApaiIO\Operations\Search();
$search->setCategory('DVD');
$search->setActor('Bruce Willis');
$search->setKeywords('Die Hard');

$formattedResponse = $apaiIo->runOperation($search);

var_dump($formattedResponse);

```

For more detailed information See: [ApaiIO - Examples](https://github.com/Exeu/apai-io/tree/master/samples)

Documentation of ApaiIO: [ApaiIO - Documentation](http://exeu.github.io/apai-io/)
