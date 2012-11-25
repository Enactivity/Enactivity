<?php
/**
 * Mustache view renderer for the Yii PHP framework
 * 
 * @author Johannes "Haensel" Bauer <thehaensel@gmail.com>
 *
 */
class MustacheViewRenderer extends CApplicationComponent implements IViewRenderer 
{
    /**
    * @var string the extension name of the view file. Defaults to '.mustache'.
    */
    public $fileExtension='.mustache';
    public $mustachePathAlias='ext.mustache.mustache.src.Mustache';
    public $templatePathAlias = 'application.views';
    
    public $mustacheOptions=array();
    
    private $_m;
    
    public function init()
    {
            // Unregister Yii autoloader
            spl_autoload_unregister(array('YiiBase','autoload'));
 
            // Register Mustache autoloader
            require Yii::getPathOfAlias($this->mustachePathAlias).'/Autoloader.php';
            Mustache_Autoloader::register(Yii::getPathOfAlias($this->mustachePathAlias).DIRECTORY_SEPARATOR.'..');
 
            // Add Yii autoloader again
            spl_autoload_register(array('YiiBase','autoload'));

            $this->_m = new Mustache_Engine(CMap::mergeArray(
                    array(
                        'cache' => Yii::app()->getRuntimePath().DIRECTORY_SEPARATOR.'Mustache'.DIRECTORY_SEPARATOR.'cache',
                        'partials_loader' => new Mustache_Loader_FilesystemLoader(Yii::getPathOfAlias($this->templatePathAlias)),
                        'escape' => function($value) {
                            return CHtml::encode($value);
                        },
                        'charset' => Yii::app()->charset,
                    ),$this->mustacheOptions)
            );
    }
    
    /**
    * Renders a view file.
    * This method is required by {@link IViewRenderer}.
    * @param CBaseController $context the controller or widget who is rendering the view file.
    * @param string $sourceFile the view file path
    * @param mixed $data the data to be passed to the view
    * @param boolean $return whether the rendering result should be returned
    * @return mixed the rendering result, or null if the rendering result is not needed.
    */
    public function renderFile($context,$sourceFile,$data,$return)
    {
            if(!is_file($sourceFile) || ($file=realpath($sourceFile))===false)
                    throw new CException(Yii::t('yii','View file "{file}" does not exist.',array('{file}'=>$sourceFile)));

            $rendered=$this->_m->render(file_get_contents($sourceFile),$data);
            
            //return $context->renderInternal(realpath($sourceFile),$data,$return);
            //THIS IS A HACK TO NOT REQUIRE THE RENDERED TEMPLATE (as renderInternal would do) AS MUSTACHE IS USING NATIVE PHP CLASSES FOR CACHING
            if(is_array($data)) 
                extract($data,EXTR_PREFIX_SAME,'data'); 
            else 
                $data=$data; 
            if($return) 
            { 
                ob_start(); 
                ob_implicit_flush(false); 
                echo $rendered;
                return ob_get_clean(); 
            } 
            else 
                echo $rendered;
    }
}
