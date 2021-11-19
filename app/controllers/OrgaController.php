<?php
namespace controllers;
use Ajax\php\ubiquity\JsUtils;
use Ubiquity\attributes\items\router\Get;
 use models\Organization;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\Router;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\URequest;

/**
  * Controller OrgaController
 * @property JsUtils $jquery
  */
class OrgaController extends \controllers\ControllerBase{


    #[Route('/orgas')]
	public function index(){
        $orgas=DAO::getAll(Organization::class);
		$this->loadView("OrgaController/index.html",['orgas'=>$orgas]);
	}

	#[Get(path: "orgas/update/{id}",name: "orgas.update")]
	public function updateForm($id){
        $orga=DAO::getById(Organization::class,$id, false);
        $df=$this->jquery->semantic()->dataForm('frm-orga',$orga);
        $df->setActionTarget(Router::path('orgas.submit'),'');
        $df->setProperty('method','post');
        $df->setFields(['id','name','submit']);
        $df->setCaptions(['','nom','Modifier']);
        $df->fieldAsHidden('id');
        $df->fieldAsSubmit('submit','green fluid');
        $this->jquery->renderView('OrgaController/update.html');
	}

    #[Post('orgas/update','orgas.submit')]
    public function update(){
        $orga=DAO::getById(Organization::class, URequest::post('id'));
        if($orga){
            URequest::setValuesToObject($orga);
            DAO::save($orga);
        }
        $this->index();
    }




}
