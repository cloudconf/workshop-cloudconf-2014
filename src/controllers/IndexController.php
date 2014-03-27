<?php
class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->books = $this->getResource("book")->getAll();
    }
}
