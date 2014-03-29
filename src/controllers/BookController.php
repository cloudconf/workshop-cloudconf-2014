<?php
class BookController extends Controller
{
    private $destination;

    public function init()
    {
        $this->destination = __DIR__ . "/../../web/images";
    }

    public function detailAction()
    {
        $params = $this->getRequest()->getParams();

        if (!array_key_exists("id", $params)) {
            throw new \RuntimeException("You have to pass an id");
        }

        $book = $this->getResource("book")->get($params["id"]);

        $this->view->book = $book;
    }

    public function addAction()
    {
        $params = $_POST;

        if (array_key_exists("add", $params)) {
            $picture = $this->uploadFile();

            $id = $this->getResource("book")->add([
                "name" => $params["name"],
                "author" => $params["author"],
                "picture" => $picture
            ]);

            $this->redirect("/", 302);
        }
    }

    private function uploadFile()
    {
        if ($_FILES["picture"]["error"] != 0) {
            return null;
        }

        $aws = $this->getResource("aws");
        $conf = $this->getResource("awsConf");

        $aws->get("s3")->putObject(array(
            'Bucket' => $conf->s3()->bucket,
            'Key'    => $_FILES["picture"]["name"],
            'SourceFile'   => $_FILES["picture"]["tmp_name"],
            'ACL'    => 'public-read',
            'ContentType' => "image/" . pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION),
            'CacheControl' => 14400,
        ));

        return $_FILES["picture"]["name"];
    }

    public function deleteAction()
    {
        $params = $this->getRequest()->getParams();

        if (!array_key_exists("id", $params)) {
            throw new \RuntimeException("You have to pass an id");
        }

        $id = $params["id"];
        $book = $this->getResource("book")->get($id);

        if (!$book) {
            throw new \RuntimeException("Book not found with id: {$id}");
        }

        $deleted = $this->getResource("book")->delete($id);

        if (!$deleted) {
            throw new \RuntimeException("Unable to delete book with id: {$id}");
        }

        if ($book["picture"]) {
            $aws = $this->getResource("aws");
            $conf = $this->getResource("awsConf");

            $aws->get("s3")->deleteObject([
                'Bucket' => $conf->s3()->bucket,
                'Key'    => $book["picture"],
            ]);
        }

        $this->redirect("/", 302);
    }
}
