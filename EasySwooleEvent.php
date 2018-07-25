<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/1/9
 * Time: 下午1:04
 */

namespace EasySwoole;

use \EasySwoole\Core\AbstractInterface\EventInterface;
use \EasySwoole\Core\Swoole\ServerManager;
use \EasySwoole\Core\Swoole\EventHelper;
use \EasySwoole\Core\Swoole\EventRegister;
use \EasySwoole\Core\Swoole\Process\ProcessManager;
use \EasySwoole\Core\Http\Request;
use \EasySwoole\Core\Http\Response;
use \EasySwoole\Core\Component\Di;

use \think\Db;

use \App\WebSocket\Parser as WebSocketParser;
use \App\WebSocket\Logic\Im;


Class EasySwooleEvent implements EventInterface {

    public static function frameInitialize(): void
    {
        date_default_timezone_set('Asia/Shanghai');

        // 全局初始化Db类
        // Db::setConfig(Config::getInstance()->getConf('DATABASE'));
    }

    public static function mainServerCreate(ServerManager $server,EventRegister $register): void
    {
        // // 注册WebSocket处理
        EventHelper::registerDefaultOnMessage($register, WebSocketParser::class);
        // //注册onClose事件
        $register->add($register::onClose, function (\swoole_server $server, $fd, $reactorId) {
            //清除Redis fd的全部关联
            Im::recyclingFd($fd);
        });
    }

    public static function onRequest(Request $request,Response $response): void
    {
        // TODO: Implement onRequest() method.
    }

    public static function afterAction(Request $request,Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}
