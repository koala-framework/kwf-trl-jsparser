<?php
class Kwf_TrlJsParser_UnderscoreTemplateParser
{
    protected $_results;
    public function __construct($content)
    {
        $templateSettings = array(
            'escape' => "<%-([\s\S]+?)%>",
            'interpolate' => "<%=([\s\S]+?)%>",
            'evaluate' => "<%([\s\S]+?)%>"
        );
        $matcher = '/'.implode('|', $templateSettings).'/';
        preg_match_all($matcher, $content, $matches, PREG_PATTERN_ORDER);

        $jsContent = "__p+='";
        foreach ($matches[0] as $key => $value) {
            if ($matches[1][$key]) { //escape
                $jsContent .= "'+\n((__t=(" . $matches[1][$key] . "))==null?'':_.escape(__t))+\n'";
            } else if ($matches[2][$key]) { //interpolate
                $jsContent .= "'+\n((__t=(" . $matches[2][$key] . "))==null?'':__t)+\n'";
            } else if ($matches[3][$key]) { //evaluate
                $jsContent .= "';\n" . $matches[3][$key] . "\n__p+='";
            }
        }
        $jsContent .= "';\n";

        $this->_results = Kwf_TrlJsParser_JsParser::parseContent($jsContent);
    }

    public static function parseContent($content)
    {
        $parser = new Kwf_TrlJsParser_UnderscoreTemplateParser($content);
        return $parser->getTrlCalls();
    }

    public function getTrlCalls()
    {
        return $this->_results;
    }
}
