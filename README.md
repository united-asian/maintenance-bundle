UAMMaintenanceBundle
===================

A symfony 2 bundle to manage maintenance periods for your symfony app.

Requirements
------------
* Propel ORM

Installation
------------

#### Add repository to your project's `composer.json`:

```json
"repositories": [
		{
			"type": "composer",
			"url": "http://satis.united-asian.com/symfony"
		},
		...
]
```

#### Add the bundle to your project's `composer.json`:

```json
{
    "require": {
        "uam/maintenance-bundle": "dev-master",
        ...
    }
}
```

#### Run `composer install` or `composer update` to install the bundle:

``` bash
$ php composer.phar update
```


#### Enable the bundle in the app's kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new UAM\Bundle\MaintenanceBundle\UAMMaintenanceBundle(),
    );
}
```

#### Add the bundle to the assetic configuration:

```
#config.yml
assetic:
    UAMMaintenanceBundle
```

#### If your composer.json does not include the post-install or post-update `installAssets` script handler, then run the following command:

``` bash
$ php app/console assets:install
```

or

``` bash
$ php app/console assets:install --symlink
```
#### Update your database schema

Run the following command to update the database schema.

```
$ php app/console propel:model:build
```

Usage
-----

### Create maintenance periods

### Display a warning to users about an implending maintenance period

Typically, if you have planned a maintenance operation in the near future, you want to publish a warning to your users on your app, in otder to let them know that the app will be unavailable during that time.

To do this with the UAMMaintenanceBndle, include the following code in the appropraite template of your app. If you want the warning to be displayed in all pages of your app, include this in the base template.

``` twig
{% render(controller("UAMMaintenanceBundle:Maintenance:warning")) %}
```

### Customizing the "Under maintenance" page
#### Import routing file

``` bash
uam_maintenance:
    resource: "@UAMMaintenanceBundle/Resources/config/routing/maintenance.yml"
```
#### override the layout
override the `layout.html.twig` template into your app so that page/message displayed will be consistent with the style of your app.

Or you can also override the `progress.html.twig` template for the "Under maintenence page". 

### Customizing the Admin pages
#### Import routing file

``` bash
uam_maintenance_admin:
    resource: "@UAMMaintenanceBundle/Resources/config/routing/admin.yml"
```
#### override the layout
override the `layout.html.twig` template into your app so that admin pages displayed will be consistent with the style of your app.

To access the admin pages, the user must have the role ROLE_UAM_MAINTENANCE.



Security
----

#### To access the admin pages

Admin pages are restricted to certain users. To access the admin pages, the user must have the role ROLE_UAM_MAINTENANCE.