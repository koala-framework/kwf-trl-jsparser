<?php
class Kwf_Trl_Parser_JsParser
{
    protected $_results;
    public function __construct($content)
    {
        $vendorPath = 'vendor';
        if (defined('VENDOR_PATH')) {
            $vendorPath = VENDOR_PATH;
        }
        $process = new Symfony\Component\Process\Process(getcwd()."/$vendorPath/bin/node ".__DIR__.'/JsParser.js');
        $process = $process->setInput($content);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new Exception("Parsing js file failed: ".$process->getErrorOutput());
        }
        $this->_results = json_decode($process->getOutput(), true);
    }

    public static function parseContent($content)
    {
        $parser = new Kwf_Trl_Parser_JsParser($content);
        return $parser->getTrlCalls();
    }

    public function getTrlCalls()
    {
        return $this->_results;
    }
}
