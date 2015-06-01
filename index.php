<?php

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;


// Use Loader() to autoload our model
$loader = new Loader();

$loader->registerNamespaces(array(
           'Coruja\Models' => 'models/',
       ));

$loader->register();



$di = new FactoryDefault();

//Set up the database service
$di->set('db', function(){
    return new PdoMysql(array(
        "host"      => "localhost",
        "username"  => "root",
      //  "password"  => "",
        "dbname"    => "hue"
    ));
});

$di->set('dbcoruja', function(){
    return new PdoMysql(array(
        "host"      => "localhost",
        "username"  => "root",
      //  "password"  => "",
        "dbname"    => "coruja"
    ));
});

$app = new Micro($di);

//define the routes here
//Retrieves all robots
$app->get('/{discipina}/topicos', function($disciplina) {
  echo "<h1>Welcome $disciplina!</h1>";
});


$app->put('/{disciplina}/topicos', function($disciplina) use ($app) {
  $json=$app->request->getJsonRawBody();
  $aff= new Coruja\Models\Topicos();
  foreach($json as $key=>$value){
      $aff->{$key} = $value;
  }
  if ($aff->save() == false){
    foreach ($aff->getMessages() as $message) {
            echo $message, "\n";
        }
  };

  /*$hue=new Coruja\Models\Topicos();
  $hue->description=$disciplina;
  $hue->siglaDisciplina=$disciplina;
  */

//  $value=$app->request->getJsonRawBody()
//  $hue->description=$disciplina;
//  $hue->save();
//    echo json_encode($app->request->getJsonRawBody())

});

$app->get('/{discipina}/topicos', function($disciplina) {
  $result=Coruja\Models\Topicos::findFirst("siglaDisciplina='".$disciplina."'");
  echo json_encode($result);
});



$app->handle();
