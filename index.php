<?php
DEFINE("LINE_BOT_ACCESS_TOKEN","PBlZBAfoAFF61KK23d0CDhCwBAi/2TUTcHFkBe/wZ0VMZa/UlgTw+F1ds9qK5XsjQ7C9ozeLXYQH6xHtLlT15ZGW5tH6zySHs0hcleSbeQv2O7gJjPPi5LZHY6/BCzgqMMamHa5ioOLPfsvtJpTFVQdB04t89/1O/w1cDnyilFU=");
DEFINE("LINE_BOT_SECRET_TOKEN","8a9b404a385f54b4b21557315ff0850d");

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use \LINE\LINEBot\Constant\HTTPHeader;

//LINESDKの読み込み
require_once(__DIR__."/vendor/autoload.php");

//LINEから送られてきたらtrueになる
if(isset($_SERVER["HTTP_".HTTPHeader::LINE_SIGNATURE])){

//LINEBOTにPOSTで送られてきた生データの取得
  $inputData = file_get_contents("php://input");

//LINEBOTSDKの設定
  $httpClient = new CurlHTTPClient(LINE_BOT_ACCESS_TOKEN);
  $Bot = new LINEBot($HttpClient, ['channelSecret' => LINE_BOT_SECRET_TOKEN]);
  $signature = $_SERVER["HTTP_".HTTPHeader::LINE_SIGNATURE]; 
  $Events = $Bot->parseEventRequest($InputData, $Signature);

//大量にメッセージが送られると複数分のデータが同時に送られてくるため、foreachをしている。
  foreach($Events as $event){
    $SendMessage = new MultiMessageBuilder();
    $TextMessageBuilder = new TextMessageBuilder("よろしくみずちゃん！");
    $SendMessage->add($TextMessageBuilder);
    $Bot->replyMessage($event->getReplyToken(), $SendMessage);
  }
}
