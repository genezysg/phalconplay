<?php

namespace Coruja\Models;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\InclusionIn;
use Phalcon\Mvc\Model\Validator\StringLength;

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

        $this->validate(new StringLength(
        array(
          "field" => 'siglaDisciplina',
          'max' => 3,
          'min' => 3,
          'messageMaximum' => 'We don\'t like really long names',
          'messageMinimum' => 'We want more than just their initials')
        ));


        //Check if any messages have been produced
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

}
