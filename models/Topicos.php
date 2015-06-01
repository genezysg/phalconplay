<?php

namespace Coruja\Models;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\InclusionIn;

class Topicos extends Model
{
    public $siglaDisciplina;
    public $description;

    public function initialize()
     {
         $this->setConnectionService('db');
     }


    public function getSource(){
      return "topicos";
    }
    public function validation()
    {


        //Robot name must be unique
        $this->validate(new Uniqueness(
            array(
                "field"   => "description",
                "message" => "The description name must be unique"
            )
        ));


        //Check if any messages have been produced
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

}
