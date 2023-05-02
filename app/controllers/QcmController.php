<?php

class QcmController
{
    use Controller;
    public function index($data=[])
    {
        $qcm = new QcmModel;
        $donneesQCM = $qcm->getQCM('qcm'); //ici qcm est l'id du qcm

        //exemple d'utilisation
        echo '<p>Type : '.$donneesQCM['type'].'</p><br/>';
        foreach($donneesQCM['questions'] as $question) {
            echo '<p>'.$question['text'].'</p>';
            foreach($question['choices'] as $choice) {
                echo '<p>'.$choice['text'].' '.$choice['correct'].'</p>'; //$choices['correct'] contient true si c'est une bonne réponde, sinon rien
            }
            echo '<br/>';
        }

        $qcm->ajoutQCM("oui", $donneesQCM);

        $qcm->supprimeQCM("oui");
        
        $listeQCM = $qcm->getAllQCM();
        foreach($listeQCM as $nomQCM) {
            echo '<p>t : '.$nomQCM.'</p>'; 
        }
    }
}

