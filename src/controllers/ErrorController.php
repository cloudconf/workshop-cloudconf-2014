<?php
class ErrorController extends Controller
{
    public function errorAction()
    {
        $this->view->exception = $this->getParam("exception");
    }
}
