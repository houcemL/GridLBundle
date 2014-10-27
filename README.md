gridL
=======
Under  active development.
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5b23deb6-2fee-487c-a049-7f7ab4e90fc9/big.png)](https://insight.sensiolabs.com/projects/5b23deb6-2fee-487c-a049-7f7ab4e90fc9)
##### Installation :
###### Composer (this is for Symfony > 2.0)

Add the directory to your composer.json as below:

```js
"require": {
    ...
    "lamari/grid": "dev-master"
}
```

Update/install with this command:

```
php composer.phar update lamari/grid
```
###### Step 2:  Enable the bundle

register the bundle

```php
public function registerBundles()
{
    $bundles = array(
        ...
        new Lamari\GridLBundle\GridLBundle(),
);
```
##### How to Use
###### Configuration :
add this under import in config.yml
```
- { resource: "@GridLBundle/Resources/config/services.yml" }
```
Under routing.yml :
```
gridL_rout:
    resource: "@GridLBundle/Resources/config/routing.yml"
    prefix:   /
```
###### Controller :
One action is requiered to have a nice grid !
by default
```php
public function yourAction()
{
    return $this->get("grid.entity_wrapper")->defaultGrid("SomeBundle:SomeEntity","SomeBundle:someView:EntityView.html.twig");
);
```
###### View :
```twig
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset ('bundles/gridl/css/jquery-ui-1.10.4.custom.min.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset ('bundles/gridl/css/ui.jqgrid.css') }}" />
<script src="{{ asset ('bundles/gridl/js/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
<script src="{{ asset ('bundles/gridl/js/i18n/grid.locale-en.js') }}" type="text/javascript"></script>
<script src="{{ asset ('bundles/gridl/js/jquery.jqGrid.min.js') }}" type="text/javascript"></script>
{{ jqgridL(grid)}}
```
GridL
=====
