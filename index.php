<?php
use TencentYoutuyun\Youtu;    
use TencentYoutuyun\Conf;      
use TencentYoutuyun\Auth;

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
		$content = $postObj->Content;
	    	$findme = "帐号";
		$pos = stripos($content,$findme);
	    if ($pos === false)
	    {
	    	$this->tuling($postObj);
	    }else
	    {
		$this -> freess($postObj);
	    }    
            }elseif($msgType == "image")
            {
		$pic = $postObj->PicUrl;
                $this->youtu($postObj,$pic);
            }
    }
    
    public function youtu($postObj,$pic)
    {
	require("youtu/include.php");	    
	//设置APP鉴权信息
	$appid='10116870';
	$secretId='AKIDH5lF0jv4bxEHXfRTEoCe3b0sZHpCPRp2';
	$secretKey='EPsAIF2JVXN3f6RcmpncPH5mbLuKau3U';
	$userid='1059902360';  
	//初始化年
	Conf::setAppInfo($appid, $secretId, $secretKey, $userid,conf::API_YOUTU_END_POINT);
        //人脸检测接口调用
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
		case "文本":
			$uploadRet = YouTu::generalocrurl("$pic", 1);
			$content = $uploadRet['errormsg'];
			$this -> text($postObj,$content);
			break;
		case "女孩":
			$gender = "女性";
		case "男孩":
			$uploadRet = YouTu::detectfaceurl("$pic", 1);
			if ($gender == "女性"){
			}else{$gender = "男性";}
        		$age = $uploadRet['face'][0]['age'];
        		$genderNum = $uploadRet['face'][0]['gender'];
        		$beauty = $uploadRet['face'][0]['beauty'];
			$expression = $uploadRet['face'][0]['expression'];
			$glasses = $uploadRet['face'][0]['glasses'];
			switch ($glasses)
			{
				case "0":
					$glasses = "没戴眼镜";
					break;
				case "1":
					$glasses = "戴了眼镜";
					break;
				case "2":
					$glasses = "戴了墨镜";
					break;
			}
			$hat = $uploadRet['face'][0]['hat'];
			switch ($hat)
			{
				case "0":
					$hat = "没戴帽子";
					break;
				case "1":
					$hat = "戴了帽子";
					break;
			}
        		$content ="检测结果如下：\n性别：".$gender."\n年龄：".$age."\n微笑：".$expression."\n颜值：".$beauty."\n".$glasses."\n".$hat."\n暂时只支持检测图片中一个人脸（以脸最大的为准）";
        		$this -> text($postObj,$content);
			break;
		
			/*
			$items = $uploadRet['items'];
			$itemsNum = count($items);
			$content = "";
			for ($i=0;$i<$itemsNum;$i++)
			{
				$content = $content."\n".$items[$i]["itemstring"];
			}
			$content = var_dump($content);
			$this -> text($postObj,$content);
			break;
			*/
		default:
			$content = "无法进行颜值检测，因为据我的观察，这张图片最有可能是：".$tagName;
			$this -> text($postObj,$content);
			
	}
        
    }
    public function freess()
    {
 $ch = curl_init();
 curl_setopt($ch,CURLOPT_URL,"https://get.ishadowx.net");
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
 curl_setopt($ch,CURLOPT_HEADER,0);
 
 $output = curl_exec($ch);
 if($output === FALSE ){
 echo "CURL Error:".curl_error($ch);
 }
 curl_close($ch);
 
 $tag="span";
 $attr="id";
 $values=array(
 array("ip","port","pw"),
 array("us","jp","sg"),
 array("a","b","c")
 );
 $total1 = count($values[0]);
 $total2 = count($values[1]);
 $total3 = count($values[2]);
 $result="美国"."<br />";
 for ($i=0;$i<$total1;$i++)
 {
	 for ($j=0;$j<$total2;$j++)
	 {
		 for ($k=0;$k<$total3;$k++)
		 {
			$value = $values[0][$k].$values[1][$i].$values[2][$j];
			$regex = "/<$tag.*?$attr=\"$value\".*?>(.*?)<\/$tag>/is";  
			preg_match_all($regex,$output,$results,PREG_PATTERN_ORDER);
			
			if ($k == 0){
				$result .= ($j+1)."、IP地址：".$results[1][0]." ";	
			}elseif($k == 1){
				$result .= "端口号:".$results[1][0]." ";
			}else{
				$result .= "密码:".$results[1][0]."<br />";
			}
			
		 }
		
	 }
	if($i == 0){
		$result .= "<br />"."日本"."<br />";
	}elseif($i == 1){
		$result .= "<br />"."新加坡"."<br />";
	}
 }
 $content = $result."加密方式统一为'aes-256-cfb'<br />公众号：资源CAT";
 $this->text($postObj,$content);
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
