<?php
class Kwf_TrlJsParser_JsParser
{
    protected $_results;
    public function __construct($content, $jsxMode = false)
    {
        $vendorPath = 'vendor';
        if (defined('VENDOR_PATH')) {
            $vendorPath = VENDOR_PATH;
        }
        $process = new Symfony\Component\Process\Process(getcwd()."/$vendorPath/bin/node ".__DIR__.'/JsParser.js --jsxMode=' . $jsxMode);
        $process = $process->setInput($content);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new Exception("Parsing js file failed: ".$process->getErrorOutput());
        }
        $this->_results = json_decode($process->getOutput(), true);
    }

    public static function parseContent($content, $jsxMode = false)
    {
        $parser = new Kwf_TrlJsParser_JsParser($content, $jsxMode);
        return $parser->getTrlCalls();
    }

    public function getTrlCalls()
    {
        return $this->_results;
    }
}
