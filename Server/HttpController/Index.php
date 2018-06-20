<?php
namespace App\HttpController;

use EasySwoole\Core\Http\AbstractInterface\Controller;

class Index extends Controller
{
    public function index()
    {
        $this->response()->write(phpinfo());
    }
}
