<?php

class QcmController
{
    use Controller;
    public function index($data=[])
    {
        
            $qcm = new QcmModel("./qcm.xml");
            $qcm = $qcm->getQuestions();
            show($qcm);
            header('Content-Type: application/json');
            echo json_encode($qcm);
            
        

        $this->view("qcm", $data);
    }
}

