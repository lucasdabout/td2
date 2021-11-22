<?php

namespace controllers;

use Ajax\php\ubiquity\JsUtils;
use models\Groupe;
use models\Organization;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\orm\DAO;
use Ubiquity\orm\repositories\ViewRepository;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\models\UArrayModels;

/**
 * *Controller GroupeController
 * @property JsUtils $jquery
 */

class GroupeController extends \controllers\ControllerBase
{
    private ViewRepository $repo;

    public function initialize() {
        parent::initialize();
        $this->repo??=new ViewRepository($this,Groupe::class);
    }

    public function index(){

    }

    #[Route(path:"groupe/update/{id}",name: "groupe.update")]
    public function update($id){
        $groupe=$this->repo->byId($id);
        $orgas=DAO::getAll(Organization::class);
        $this->jquery->semantic()->htmlDropdown('organization',
            $groupe->getOrganization()->getId(),
            UArrayModels::asKeyValues($orgas,'getId'))->asSelect('organization');
        $this->jquery->renderView('GroupeController/update.html');
    }


    #[Post('groupe/submit',name:'groupe.submit')]
    public function submit(){
        $this->repo->byId(URequest::post('id'));
    }
}