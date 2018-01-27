<?php
use TencentYoutuyun\Youtu;    
use TencentYoutuyun\Conf;      
use TencentYoutuyun\Auth;
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
            }elseif($msgType == "image")
            {
		$pic = $postObj->PicUrl;
                $this->youtu($postObj,$pic);
            }
    }
    
    public function youtu($postObj,$pic)
    {
	require("youtu/include.php");	    
	//设置APP鉴权信息h
	$appid='10116870';
	$secretId='AKIDH5lF0jv4bxEHXfRTEoCe3b0sZHpCPRp2';
	$secretKey='EPsAIF2JVXN3f6RcmpncPH5mbLuKau3U';
	$userid='1059902360';  
	//初始化
	Conf::setAppInfo($appid, $secretId, $secretKey, $userid,conf::API_YOUTU_END_POINT);
        //人脸检测接口调用
        $uploadRet = YouTu::fuzzydetecturl("$pic",1);

if ($uploadRet['fuzzy_confidence']<=0.3){
$uploadRet = YouTu::imagetagurl("$pic");
$tags = $uploadRet['tags'];
$tagsNum = count($tags);

$maxConfidence = 0;
for ($i=0;$i<$tagsNum;$i++)
{
	$tagConfidence = $tags[$i]['tag_confidence'];
	if ($maxConfidence <= $tagConfidence)
	{
		$tagName = $tags[$i]['tag_name'];
		$maxConfidence = $tagConfidence;
	}
}
switch ($tagName)
{
	case "女孩":
		$uploadRet = YouTu::detectfaceurl("$pic",1);
		$gender = "女性";

	case "男孩":
		$uploadRet = YouTu::detectfaceurl("$pic",1);
		if ($gender == "女性"){
		
		}else{$gender = "男性";echo "男性";}
		$age = $uploadRet['face'][0]['age'];
		$beauty = $uploadRet['face'][0]['beauty'];
		$expression = $uploadRet['face'][0]['expression'];
		$glasses = $uploadRet['face'][0]['glasses'];
		
		if ($glasses == "0"){
			$glasses = "没戴眼镜";
		}elseif($glasses == "1"){
			$glasses = "戴了眼镜";
		}else{$glasses = "戴了墨镜";}
		$content ="检测结果如下：\n年龄：".$age."\n性别：".$gender."\n颜值：".$beauty."\n微笑程度：".$expression."\n".$glasses;
		echo $content;
		$this -> text($postObj,$content);
		break;
	case "文本":
		$uploadRet = YouTu::generalocrurl("$pic", $seq = '');
		var_dump($uploadRet);
		$items = $uploadRet['items'];
		$itemsNum = count($items);
		$content = "";
		for ($i=0;$i<$itemsNum;$i++)
		{
			$content = $content."\n".$items[$i]['itemstring'];
		}
		$content = $pic;
		$this -> text($postObj,$content);
		break;
	default:
		$content = $tagName;
		
		$this -> text($postObj,$content);
}}else
{
	//var_dump($uploadRet);
	$a = 0.8;
	var_dump($a);
	echo "亲，你提供的图片太模糊了，我看不清啊";
}
    }
    
    public function tuling($postObj)
    {
        $key = "dd9ea2173ef44d29b1ad729346639c46";
        $content = $postObj->Content;
        $re = json_decode(file_get_contents('http://www.tuling123.com/openapi/api?key='.$key.'&info='.$content.'&useid='.$fromUsername),true);
        $code = $re['code'];
        switch ($code){
            case 100000:    //普通文本类
                $content = $re['text'];
                $this->text($postObj,$content);
                break;
            case 200000:    //链接类
                $content = $re['text'].$re['url'];
                $this->text($postObj,$content);
                break;
            case 302000:    //新闻类
                $list = $re['list'];
                $articleCount = (count($list) >= 6) ? 6 : count($list);
                $this->news($postObj,$list,$articleCount);
                break;
            case 308000:    //菜谱类
                $list = $re['list'][0];
                $articleCount = 1;
                $this->news($postObj,$list,$articleCount);
                break;
            case 40004:    //次数用完
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
