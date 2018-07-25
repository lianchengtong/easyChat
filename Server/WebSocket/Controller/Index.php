<?php
namespace App\WebSocket\Controller;

use EasySwoole\Core\Swoole\ServerManager;
use EasySwoole\Core\Swoole\Task\TaskManager;
use App\WebSocket\Logic\Im;

/**
 * Index控制器
 */
class Index extends Base
{
    /**
     * 进入房间
     */
    public function intoRoom()
    {
        // TODO: 业务逻辑自行实现
        $param = $this->request()->getArg('data');
        $userId = (int)$param['userId'];
        $roomId = (int)$param['roomId'];

        $fd = $this->client()->getFd();
        Im::bindUser($userId, $fd);
        Im::joinRoom($roomId, $fd, $userId);
        $this->response()->write("加入{$roomId}房间");
    }

    /**
     * 发送信息到房间
     */
    public function sendToRoom()
    {
        // TODO: 业务逻辑自行实现
        $param = $this->request()->getArg('data');
        $message = $param['message'];
        $roomId = (int)$param['roomId'];

        $list = Im::selectRoomFd($roomId);
        //异步推送
        TaskManager::async(function ()use($list, $roomId, $message){
            foreach ($list as $fd) {
                ServerManager::getInstance()->getServer()->push((int)$fd, $message);
            }
        });
    }

    /**
     * 发送私聊
     */
    public function sendToUser()
    {
        // TODO: 业务逻辑自行实现
        $param = $this->request()->getArg('data');
        $message = $param['message'];
        $userId = (int)$param['userId'];

        $fdList = Im::getUserFd($userId);
        var_dump($fdList);
        //异步推送
        // TaskManager::async(function ()use($fdList, $userId, $message){
        //     foreach ($fdList as $fd) {
        //         ServerManager::getInstance()->getServer()->push($fd, $message);
        //     }
        // });
    }
}
