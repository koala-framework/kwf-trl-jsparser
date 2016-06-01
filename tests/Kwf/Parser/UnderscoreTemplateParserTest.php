<?php
class UnderscoreTemplateParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider parseDataProvider
     */
    public function testParseData($content, $expectedTrlCalls)
    {
        $trlCalls = Kwf_TrlJsParser_UnderscoreTemplateParser::parseContent($content);
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
            array("<%=kwfTrl.trl('undefined word')%>", array(
                array('before'=> "kwfTrl.trl('undefined word')", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trl')
            )),
            array("<%=kwfTrl.trl(\"undefined word\")%>", array(
                array('before'=> "kwfTrl.trl(\"undefined word\")", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trl')
            )),
            array("<%=kwfTrl.kwfTrl('undefined word')%>", array(
                array('before'=> "kwfTrl.trlKwf('undefined word')", 'text'=>'undefined word', 'source'=>'kwf', 'type'=>'trl')
            )),
            array("<%=kwfTrl.kwfTrl(\"undefined word\")%>", array(
                array('before'=> "kwfTrl.trlKwf(\"undefined word\")", 'text'=>'undefined word', 'source'=>'kwf', 'type'=>'trl')
            )),
            //TRLC
            array("<%=kwfTrl.trlc('context', 'undefined word')%>", array(
                array('before'=>"kwfTrl.trlc('context', 'undefined word')", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trlc', 'context'=>'context')
            )),
            array("<%=kwfTrl.trlc(\"context\", \"undefined word\")%>", array(
                array('before'=>"kwfTrl.trlc(\"context\", \"undefined word\")", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trlc', 'context'=>'context')
            )),
            //TODO same with trlKwf
            //TRLP
            array("<%=kwfTrl.trlp('undefined word', 'undefined words', 10)%>", array(
                array('before'=>"kwfTrl.trlp('undefined word', 'undefined words', 10)", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trlp', 'plural'=>'undefined words')
            )),
            //TODO " instead of '
            //TODO same with trlKwf
            //TRLCP
            array("<%=kwfTrl.trlcp('context', 'undefined word', 'undefined words', 10)%>", array(
                array('before'=>"kwfTrl.trlcp('context', 'undefined word', 'undefined words', 10)", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trlcp', 'context'=>'context', 'plural'=>'undefined words')
            )),
            //TODO " instead of '
            //TODO same with trlKwf

            array("<div class=\"kwcBem_trl\"><%=kwfTrl.trl('undefined word')%></div>", array(
                array('before'=> "kwfTrl.trl('undefined word')", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trl')
            )),
            array("<div class=\"kwcBem__trl\"><%=kwfTrl.trl('undefined word')%></div><div class=\"kwcBem__trl2\"><%=kwfTrl.trl('undefined word2')%></div>", array(
                array('before'=> "kwfTrl.trl('undefined word')", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trl'),
                array('before'=> "kwfTrl.trl('undefined word2')", 'text'=>'undefined word2', 'source'=>'web', 'type'=>'trl')
            )),
            array("<div class=\"kwcBem_trl\"><%kwfTrl.trl('undefined word')%></div>", array(
                array('before'=> "kwfTrl.trl('undefined word')", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trl')
            )),
            array("<div class=\"kwcBem__trl\"><%=kwfTrl.trl('undefined word3')%><%-kwfTrl.trl('undefined word')%></div><div class=\"kwcBem__trl2\"><%=kwfTrl.trl('undefined word2')%></div>", array(
                array('before'=> "kwfTrl.trl('undefined word3')", 'text'=>'undefined word3', 'source'=>'web', 'type'=>'trl'),
                array('before'=> "kwfTrl.trl('undefined word')", 'text'=>'undefined word', 'source'=>'web', 'type'=>'trl'),
                array('before'=> "kwfTrl.trl('undefined word2')", 'text'=>'undefined word2', 'source'=>'web', 'type'=>'trl')
            ))
        );
    }
}
