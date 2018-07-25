<?php
namespace App\WebSocket\Controller;

use EasySwoole\Core\Socket\AbstractInterface\WebSocketController;

/**
 * 基础控制器
 */
class Base extends WebSocketController
{
    /**
     * 找不到方法
     * @param  ?string $actionName 请求方法名称
     * @return JSON
     */
    protected function actionNotFound(?string $actionName)
    {
        $this->response()->write("action call {$actionName} not found");
    }

}
