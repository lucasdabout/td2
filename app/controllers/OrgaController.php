<?php
namespace controllers;
use Ajax\php\ubiquity\JsUtils;
use Ubiquity\attributes\items\router\Get;
 use models\Organization;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\Router;
use Ubiquity\orm\DAO;
use Ubiquity\orm\repositories\ViewRepository;
use Ubiquity\utils\http\URequest;

/**
  * Controller OrgaController
 * @property JsUtils $jquery
  */
class OrgaController extends \controllers\ControllerBase{
    private ViewRepository $repo;

    public function initialize() {
        parent::initialize();
        $this->repo??=new ViewRepository($this,Organization::class);
    }

    #[Route('/orgas', name:'orga.index')]
	public function index(){
        $this->repo->all();
		$this->loadView("OrgaController/index.html");
	}

	#[Get(path: "orgas/update/{id}",name: "orgas.update")]
	public function updateForm($id){
        $orga=$this->repo->byId($id, false);
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
        $orga=$this->repo->byId(URequest::post('id'));
        if($orga){
            URequest::setValuesToObject($orga);
            $this->repo->save($orga);
        }
        $this->index();
    }





	#[Get(path: "orga/getOne/{id}",name: "orgas.getOne")]
	public function getOne($id){
		$this->repo->byId($id,['users.groupes','groupes.users']);
		$this->loadView('OrgaController/getOne.html');

	}

}
