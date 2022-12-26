<?php

namespace App\Http\Controllers\Governments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Government;
use App\Traits\AllTrait;
use Illuminate\Support\Facades\Validator;

class GovernmentController extends Controller
{
    use AllTrait;
    public function store(Request $request){
        try{
            //validate request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:191|unique:governments',
                'registration_status' => 'boolean|required',
            ]);
            if ($validator->fails()) {
                return $this->returnError(422, 'sorry this is an error in validation', 'Error', $validator->errors());
            }
            //store request in db
            Government::create([
                'name' => $request->name,
                'registration_status' => $request->registration_status
            ]);

            return $this->returnSuccess(200, 'this Government is added succssfuly' );

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function changeReqStatus($id){
        try{
            $government = Government::find($id);
            if(! $government){
                return $this->returnError(422, 'sorry this is not exists');
            }
            if($government['registration_status'] == 1){
                $government->update([
                    'registration_status' => 0
                ]);
                return $this->returnSuccess(200, 'this Government is closed in regester succssfully' );
            }else{
                $government->update([
                    'registration_status' => 1
                ]);
                return $this->returnSuccess(200, 'this Government is open to regester succssfuly' );
            }
        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function update(Request $request, $id){
        try{
            //find intiative
            $government = Government::find($id);
            if(! $government){
                return $this->returnError(422, 'sorry this is not exists');
            }
            //validate request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:191',
                'registration_status' => 'boolean|required',
            ]);
            if ($validator->fails()) {
                return $this->returnError(422, 'sorry this is an error in validation', 'Error', $validator->errors());
            }
            //store request in db
            $government->update([
                'name' => $request->name,
                'registration_status' => $request->registration_status
            ]);

            return $this->returnSuccess(200, 'this Initiative is updated succssfuly' );

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function getOne($id){
        try{
            $government = Government::find($id);
            if(! $government){
                return $this->returnError(422, 'sorry this is not exists');
            }
            $oneGovernment = $government->with(['news'])->where('id', $id)->first();

            return $this->returnData(200, 'there is all initiative', $oneGovernment);
            
        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function getAll(){
        try{
            $government = Government::select("*")->with(['news'])->paginate(PAGINATION_COUNT);
            
            if($government->count() >= 1){
                return $this->returnData(200, 'there is all government', $government);
            }
            return $this->returnError(422, 'sorry this is no data');
        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function destroy($id){
        try{
            $government = Government::find($id);
            if($government){
            //delete news with relation in initiative
            $government->news()->delete();
            //delete employee with relation in initiative
            $government->employee()->delete();
            //delete from database
            $government->delete();
            return $this->returnSuccess(200, 'This government successfuly Deleted');

            }
            return $this->returnError(422, 'sorry this id not exists');

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');

        }
    }
}
