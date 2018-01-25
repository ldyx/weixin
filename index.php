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
        
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $content = trim($postObj->Content);
        $time = time();
        $key = "dd9ea2173ef44d29b1ad729346639c46";
        $re = json_decode(file_get_contents('http://www.tuling123.com/openapi/api?key='.$key.'&info='.$content.'&useid='.$fromUsername),true);
        $code = $re['code'];
        switch ($code){
            case 100000:
                $content = $re['text'];
                break;
            case 200000:
                $content = $re['text'].$re['url'];
                break;
            case 40004:
                $content= '今天累了，明天接着聊啊';
                break;
            default:
                $content = $re['text'];
        }
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";
         $msgType = "text";
         $contentStr = date("Y-m-d H:i:s",time());
         $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $content);
         echo $resultStr;
    }
}
?>
