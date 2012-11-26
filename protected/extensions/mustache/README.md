#EMustache - Mustache templating for Yii

This extension is based on the excellent work of Justin Hileman aka. "bobthecow" => mustache.php at https://github.com/bobthecow/mustache.php
The idea was to make mustache templating with Yii as easy as possible. It therefore uses the familiar Yii rendering syntax. In order to make
this extension as fast as possible EMustache uses Mustache.php's built in caching functionality.
By default these cached views are stored under /protected/runtime/Mustache/cache

##INSTALL:

1.) Add the extension to Yii by placing it in your application's extension folder (for example '/protected/extensions')
2.) Add the viewRenderer configuration to the main config (within the "components section")

~~~
	        'viewRenderer' => array(
                    'class' => 'application.extensions.EMustache.EMustacheViewRenderer',
                )
~~~
       		

3.) Add additional options. To pass mustache.php specific options you may use the following syntax. Example:

~~~

                'viewRenderer' => array(
                    'class' => 'application.extensions.EMustache.EMustacheViewRenderer',
                    'mustacheOptions'=>array(
                        'charset' => Yii::app()->charset
                    )
                )
~~~

Please note that the options "partial_loader","charset" and "escape" are already set to make Mustache.php usable with Yii's conventions.
E.g.: Escaping is done via Yii's CHtml::encode() and views/partials are searched within "protected/views". Only change them if you know what you do.

##USAGE:

With layouts:

protected/layouts/main.mustache:

~~~
<!DOCTYPE html>
    <html>
    <head>
        <title>Test</title>
    </head>
    <body>
        <div class="container" id="page">
            {{{content}}}
        </div><!-- page -->
    </body>
</html>

~~~

protected/views/site/index.mustache:

~~~
Hello {{name}}
You have just won ${{value}}!
{{#in_ca}}
Well, ${{taxed_value}}, after taxes.
{{/in_ca}}
~~~

protected/controllers/SiteController.php

~~~
<?php

class SiteController extends Controller
{	
	public function actionIndex()
	{
		$this->layout="//layouts/main";
		$this->render('index',array('name'=>'Chris','value'=>10000,'taxed_value'=>10000 - (10000 * 0.4),'in_ca'=>true));
	}
}
~~~

http://localhost/mustacheExample/index.php will output:

~~~
<!DOCTYPE html>
    <html>
    <head>
        <title>Test</title>
    </head>
    <body>
        <div class="container" id="page">
            Hello Chris
            You have just won $10000!
            Well, $6000.0, after taxes.
        </div><!-- page -->
    </body>
</html>
~~~

Partials:

protected/views/site/index.mustache:

~~~
Hello {{name}}
You have just won ${{value}}!
{{#in_ca}}
Well, ${{taxed_value}}, after taxes.
{{/in_ca}}
And here comes a partial 
{{>site/partial}}
~~~

protected/views/site/partial.mustache:

~~~
I am a partial with name {{partialName}} and you are probably named {{name}}
~~~

Partials will automatically have access to variables of their parents.

~~~
<?php
class SiteController extends Controller
{	
	public function actionIndex()
	{
		$this->layout="//layouts/main";
		$this->render('index',array('name'=>'Chris','value'=>10000,'taxed_value'=>10000 - (10000 * 0.4),'in_ca'=>true,'partialName'=>'IAMAPARTIAL'));
	}
}
~~~

##Using models

~~~
<?php
class SiteController extends Controller
{	
	public function actionIndex()
	{
		$model=new YiiModel;
                $model->name='Haensel;
                $model->age=30;
                $this->render('index',array('model'=>$model);
	}
}
~~~

protected/views/site/index.mustache:

~~~
Name: {{model.name}}
Age: {{model.age}}
~~~

Full mustache syntax: http://mustache.github.com/mustache.5.html