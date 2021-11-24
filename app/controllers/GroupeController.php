<?php

namespace controllers;

use Ajax\php\ubiquity\JsUtils;
use models\Groupe;
use models\Organization;
use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\Router;
use Ubiquity\orm\DAO;
use Ubiquity\orm\repositories\ViewRepository;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\UResponse;
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
        $this->repo->all();
        $this->loadView("OrgaController/index.html");
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
        $groupe=$this->repo->byId(URequest::post('id'));
        URequest::setValuesToObject($groupe);
        $orga=DAO::getById(Organization::class, URequest::post('organization'));
        $groupe->setOrganization($orga);
        $this->repo->update($groupe);
        UResponse::header('location', Router::url('orgas.getOne',[$orga->getId()]));
    }

    #[Get(path: "groupe/addGroupe",name: 'groupes.addGroupe')]
    public function addGroupe(){
        $orgas=DAO::getAll(Organization::class);
        $this->jquery->semantic()->htmlDropdown('organization',
           '',UArrayModels::asKeyValues($orgas,'getId'))->asSelect('organization');



        $group=new Groupe();
        URequest::setValuesToObject($group);
        $users=DAO::getAllById( User::class, explode(',',URequest::post('users')));
        $group->setUsers($users);
        DAO::update($group,true);





        $this->jquery->renderView('GroupeController/addGroupe.html');
    }

    #[Post(path: "groupe/add",name: 'groupes.add')]
    public function add(){
        $groupe=new Groupe();
        URequest::setValuesToObject($groupe);
        if(DAO::insert($groupe)){
            $this->index();
        }
    }



}