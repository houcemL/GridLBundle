gridL
=======
Under  active development.

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
    return $this->get("grid.entity_wrapper")->_defaultGrid("SomeBundle:SomeEntity","SomeBundle:someView:EntityView.html.twig");
);
```
GridL
=====
