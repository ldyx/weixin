<?php
header('Content-type:text');
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->style();

class wechatCallbackapiTest
{
    public function style()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $msgType = $postObj->MsgType;
            if ($msgType == "text")
            {
                $this->tuling($postObj);
            }
    }
    
    public function tuling($postObj)
    {
        $key = "dd9ea2173ef44d29b1ad729346639c46";
        $content = $postObj->Content;
        $re = json_decode(file_get_contents('http://www.tuling123.com/openapi/api?key='.$key.'&info='.$content.'&useid='.$fromUsername),true);
        $code = $re['code'];
        switch ($code){
            case 100000:
                $content = $re['text'];
                $this->text($postObj,$content);
                break;
            case 200000:
                $content = $re['text'].$re['url'];
                $this->text($postObj,$content);
                break;
            case 302000:
                $list = $re['list'];
                $articleCount = 6;
                $articleCount = (count($list) >= 6) ? 6 : count($list);
                $this->news($postObj,$list,$articleCount);
                break;
            case 308000:
                $list = $re['list'][0];
                $articleCount = 1;
                $this->news($postObj,$list,$articleCount);
                break;
            case 40004:
                $content= '今天累了，明天接着聊啊';
                $this->text($postObj,$content);
                break;
            default:
                $content = $re['text'];
                $this->text($postObj,$content);
        }
    }
    
    public function text($postObj,$content)
    {
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $time = time();
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $content);
        echo $resultStr;
    }
      
    public function news($postObj,$list,$articleCount)
    {
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $time = time();
        $articles = "";
        if ($articleCount == 1)
        {
            $li = array_values($list);
            $title = $li[0];
            $picurl = $li[1];
            $description = $li[2];
            $url = $li[3];
            $article = "<item>
                         <Title><![CDATA[%s]]></Title>
                         <Description><![CDATA[%s]]></Description>
                         <PicUrl><![CDATA[%s]]></PicUrl>
                         <Url><![CDATA[%s]]></Url>
                         </item>";
            $articles = $articles.sprintf($article,$title,$description,$picurl,$url);
        }else{
        for ($i=0;$i<=$articleCount-1;$i++)
        {
            $li = array_values($list[$i]);
            $title = $li[0];
            $description = $li[1];
            $picurl = $li[2];
            $url = $li[3];
            $article = "<item>
                         <Title><![CDATA[%s]]></Title>
                         <Description><![CDATA[%s]]></Description>
                         <PicUrl><![CDATA[%s]]></PicUrl>
                         <Url><![CDATA[%s]]></Url>
                         </item>";
            $articles = $articles.sprintf($article,$title,$description,$picurl,$url);
        }}
        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[news]]></MsgType>
                        <ArticleCount>%s</ArticleCount><Articles>".$articles."</Articles></xml>";
        $resultStr = sprintf($textTpl,$fromUsername,$toUsername,$time,$articleCount);
        echo $resultStr;        
    }
}
?>
