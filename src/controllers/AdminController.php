<?php
class AdminController extends Controller
{
    public function loginAction()
    {
        if (array_key_exists("login", $_POST)) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $user = $this->getResource("user")->login($username, $password);
            if ($user) {
                $_SESSION["auth"] = true;

                $this->redirect("/", 302);
            }

            $this->view->username = $username;
        }
    }

    public function logoutAction()
    {
        session_destroy();
        $this->redirect("/", 302);
    }
}
