<?php

class ApiController extends Controller
{

    private $id;
    public $data = array();

    protected function getRequest()
    {
        $posted = ($_SERVER['REQUEST_METHOD']==='POST');
        $this->request = 
            [
                'posted'    => $posted,
                'page'      => $this->getRequestVar('page', $posted, 'product'),
                'type'      => $this->getRequestVar('type', $posted, 'json'),
                'qty'       => $this->getRequestVar('qty', $posted, 'one'),
                'limit'     => $this->getRequestVar('limit', $posted, 0),
                'id'        => $this->getRequestVar('id', $posted, 0)
            ];
    }

    protected function validateRequest()
    {
        $this->id = intval($this->request['id']);
        if($this->id == 0)
        {
            switch($this->request['qty'])
            {
                case "all":
                    $check = new ApiModel($this->request['qty'], $this->id);
                    $check = $check->getContent();
                    $this->data = $check;

                    return $this->data;
                    break;
                case "limit":
                    $check = new ApiModel($this->request['qty'], $this->id, $this->request['limit']);
                    $check = $check->getContent();
                    $this->data = $check;

                    return $this->data;
                    break;
            }
        }
        else
        {
            $this->id = $this->request['id'];
        }

        if($this->id > 0)
        {
            $check = new ApiModel($this->request['qty'], $this->id);
            $check = $check->getContent();
            $this->data = $check;

            return $this->data;
        }
        else
        {
            $this->error = array("request" => "failed", "message" => "invalid product");
        }

    }

    public function showResponse()
    {
        switch($this->request['type'])
        {
            case "json":
                $show = json_encode($this->data);
                echo $show;
                break;
            case "xml":
                $data = new XML($this->data);
                $data = $data->getContent();
                echo $data;
                break;
            case "html":
                $data = file_get_contents(ROOTURL."/index.php?page=webshop");
                echo $data;
            }
    }
}