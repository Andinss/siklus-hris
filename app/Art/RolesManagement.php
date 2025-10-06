<?php 

namespace App\Art;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;
use App\Models\Module;
use App\Models\Action;
use App\Models\Privilege;

class RolesManagement extends Facade
{

    public static function user()
    {
        return Auth::guard()->id();
    }

    // for middleware

    public static function role($value1, $value2)
    {
        $valReturn = false;
        $id_module = Module::where('name', $value1)->pluck('id')->first();
        $id_action = Action::where('name', $value2)->pluck('id')->first();
        $roles = new Privilege;
        $userHasModules = $roles->where('user_id', self::user())->where('module_id', $id_module)->where('action_id', $id_action)->get();
        if($userHasModules->count() > 0)
        {
            $valReturn = true;
        }
        return $valReturn;
    }

    // end of middleware

    public static function hasModule()
    {
    	$roles = new Privilege;
    	$userHasModules = $roles->where('user_id', self::user())->get();
    	$modules = NULL;
        $id_modules = NULL;
        foreach ($userHasModules as $uhm) {
    		if($id_modules != $uhm->id_modules)
				$modules[] = $uhm->module->name;
    		$id_modules = $uhm->id_modules;
    	}
    	return $modules;
    }

    public static function hasAction($value)
    {
    	$modules = Module::where('name', $value)->first();
      if ($modules) {
        $id_modules = $modules->id;
      	$roles = new Privilege;
      	$moduleHasActions = $roles->where('user_id', self::user())->where('module_id', $id_modules)->get();
      	$actions = NULL;
      	foreach ($moduleHasActions as $mhs) {
      		$actions[] = $mhs->action->name;
      	}
        return $actions;
      }else {
        return FALSE;
      }
    }

    public static function moduleStart($value)
    {
        $valReturn = false;
        $hasModule = self::hasModule();
        if(!empty($hasModule))
        {
            if(in_array($value, $hasModule))
              $valReturn = true;
        }
        return $valReturn;
    }

    public static function actionStart($value1, $value2)
    {
        $valReturn = false;
        $unpack_value2 = explode("|", $value2);
        $hasAction = self::hasAction($value1);
        if(!empty($hasAction))
        {
          if(count($unpack_value2) < 2){
            if(in_array($unpack_value2[0], $hasAction))
              $valReturn = true;
            else
              $valReturn = false;
          }else {
            for ($i=0; $i < count($unpack_value2); $i++) {
              if(in_array($unpack_value2[$i], $hasAction))
                $val[] = true;
              else
                $val[] = false;
            }
            $condition = '';
            for ($x=0; $x < count($val); $x++) {
              if($x % 2 == 0 ){
                  $condition .= " or ";
              }
              $condition .= $val[$x];
            }
            if ($condition) {
              $valReturn = true;
            }
            // print_r($condition);
          }
          return $valReturn;
        }else{
          return FALSE;
        }
    }
}
