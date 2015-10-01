<?php
class JsParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider parseDataProvider
     */
    public function testParseData($content, $expectedTrlCalls)
    {
        $trlCalls = Kwf_TrlJsParser_JsParser::parseContent($content);
        foreach ($trlCalls as $key => $trlCall) {
            //$trlCall['error']
            $this->assertEquals($trlCall['before'], $expectedTrlCalls[$key]['before']);
            $this->assertEquals($trlCall['text'], $expectedTrlCalls[$key]['text']);
            $this->assertEquals($trlCall['source'], $expectedTrlCalls[$key]['source']);
            $this->assertEquals($trlCall['type'], $expectedTrlCalls[$key]['type']);
            if (isset($expectedTrlCalls[$key]['context'])) {
                $this->assertEquals($trlCall['context'], $expectedTrlCalls[$key]['context']);
            } else {
                $this->assertEquals($trlCall['context'], null);
            }
            if (isset($expectedTrlCalls[$key]['plural'])) {
                $this->assertEquals($trlCall['plural'], $expectedTrlCalls[$key]['plural']);
            } else {
                $this->assertEquals($trlCall['plural'], null);
            }
        }
    }

    public function parseDataProvider()
    {
        return array(
            // TRL
            array("trl('undefined word')", array(
                array('before'=> "trl('undefined word')", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trl')
            )),
            array("trl(\"undefined word\")", array(
                array('before'=> "trl(\"undefined word\")", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trl')
            )),
            array("trlKwf('undefined word')", array(
                array('before'=> "trlKwf('undefined word')", 'text'=>'undefined word', 'source'=>'kwf', 'type'=>'trl')
            )),
            array("trlKwf(\"undefined word\")", array(
                array('before'=> "trlKwf(\"undefined word\")", 'text'=>'undefined word', 'source'=>'kwf', 'type'=>'trl')
            )),
            //TRLC
            array("trlc('context', 'undefined word')", array(
                array('before'=>"trlc('context', 'undefined word')", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trlc', 'context'=>'context')
            )),
            array("trlc(\"context\", \"undefined word\")", array(
                array('before'=>"trlc(\"context\", \"undefined word\")", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trlc', 'context'=>'context')
            )),
            //TODO same with trlKwf
            //TRLP
            array("trlp('undefined word', 'undefined words', 10)", array(
                array('before'=>"trlp('undefined word', 'undefined words', 10)", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trlp', 'plural'=>'undefined words')
            )),
            //TODO " instead of '
            //TODO same with trlKwf
            //TRLCP
            array("trlcp('context', 'undefined word', 'undefined words', 10)", array(
                array('before'=>"trlcp('context', 'undefined word', 'undefined words', 10)", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trlcp', 'context'=>'context', 'plural'=>'undefined words')
            ))
            //TODO " instead of '
            //TODO same with trlKwf
        );
    }
}
