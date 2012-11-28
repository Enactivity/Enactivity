<?php
/**
 * Mustache renderer
 *
 */
Yii::import('site.common.extensions.Mustache.src.Mustache_Engine');

class EMustacheViewRenderer extends CApplicationComponent implements IViewRenderer
{
    /**
    * @var string the extension name of the view file. Defaults to '.php'.
    */
    public $fileExtension='.mustache';
    public $mustachePathAlias='ext.mustache.src.mustache';
    
    public $extension = true;
    public $templatePathAlias = 'application.views';
    public $useRuntimePath=true;
    public $filePermission=0755;
    
    private $_m;
    private $_output;
    
    public function init()
    {
            require Yii::getPathOfAlias($this->mustachePathAlias).'/Autoloader.php';
            Yii::registerAutoloader(array('Mustache_Autoloader', 'register'), true);
            $this->_m = new Mustache_Engine;
    }
    
    protected function generateViewFile($sourceFile,$viewFile,$context,$data)
    {            
            $template = file_get_contents($sourceFile);
            $template = preg_replace('/%%%(.+)%%%/e', "Yii::app()->request->baseUrl . '/$1'", $template);
            $template = preg_replace('/%%(\w+\/\w+)%%/e', "Yii::app()->createUrl('$1')", $template);
            $template = preg_replace('/{{>(.+)}}/e', "\$context->renderPartial('$1',\$data,true)", $template);
            $this->_output=$this->_m->render($template,$data);
            file_put_contents($viewFile,$this->_output);
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
            $viewFile=$this->getViewFile($sourceFile);

            if(@filemtime($sourceFile)>@filemtime($viewFile))
            {
                    $viewFile = preg_replace('"\.mustache$"', '.php', $viewFile);
                    $this->generateViewFile($sourceFile,$viewFile,$context,$data);
                    @chmod($viewFile,$this->filePermission);
            }
            return $context->renderInternal($viewFile,$data,$return);
    }

    /**
        * Generates the resulting view file path.
        * @param string $file source view file path
        * @return string resulting view file path
        */
    protected function getViewFile($file)
    {
            if($this->useRuntimePath)
            {
                    $crc=sprintf('%x', crc32(get_class($this).Yii::getVersion().dirname($file)));
                    $viewFile=Yii::app()->getRuntimePath().DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$crc.DIRECTORY_SEPARATOR.basename($file);
                    if(!is_file($viewFile))
                            @mkdir(dirname($viewFile),$this->filePermission,true);
                    return $viewFile;
            }
            else
                    return $file.'c';
    }
}
