<?php
return array("/orgas/"=>["controller"=>"controllers\\OrgaController","action"=>"index","parameters"=>[],"name"=>"orga.index","cache"=>false,"duration"=>0],"/orgas/update/(.+?)/"=>["get"=>["controller"=>"controllers\\OrgaController","action"=>"updateForm","parameters"=>[0],"name"=>"orgas.update","cache"=>false,"duration"=>0]],"/orgas/update/"=>["post"=>["controller"=>"controllers\\OrgaController","action"=>"update","parameters"=>[],"name"=>"orgas.submit","cache"=>false,"duration"=>0]],"/orga/getOne/(.+?)/"=>["get"=>["controller"=>"controllers\\OrgaController","action"=>"getOne","parameters"=>[0],"name"=>"orgas.getOne","cache"=>false,"duration"=>0]]);
