<?php

namespace App\Http\Controllers\Governments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Gallary;
use App\Models\Hierarchical;
use DB;
use App\Traits\AllTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    use AllTrait;
    public function store(Request $request){
        try{
            //validate request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:191',
                'img' => 'image|mimes:jpeg,png,jpg,gif,svg',
                'government_id' => 'required|integer|max:11',
                'hierarchical_id' => 'required|integer|max:11'
            ]);
            if ($validator->fails()) {
                return $this->returnError(422, 'sorry this is an error in validation', 'Error', $validator->errors());
            }
            //store request in db
            Employee::create([
                'name' => $request->name,
                'government_id' => $request->government_id,
                'hierarchical_id' => $request->hierarchical_id
            ]);
            //store img in file
            $file_extentions = $request->img->getClientOriginalExtension();
            $file_name = uniqid('', true) . '.' . $file_extentions;
            $request->img->move("gallary", $file_name);
            // get id of employee
            $lastNewOfEmployee = Employee::select('id')->latest('id')->first();
            Gallary::create([
                'name' => $file_name,
                'employee_id' => $lastNewOfEmployee->id,
            ]);
            return $this->returnSuccess(200, 'this Employee is added succssfuly' );

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function update(Request $request, $id){
        try{
            //find intiative
            $employee = Employee::find($id);
            if(! $employee){
                return $this->returnError(422, 'sorry this is not exists');
            }
            //validate request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:191',
                'img' => 'image|mimes:jpeg,png,jpg,gif,svg',
                'government_id' => 'required|integer|max:11',
                'hierarchical_id' => 'required|integer|max:11'
            ]);
            if ($validator->fails()) {
                return $this->returnError(422, 'sorry this is an error in validation', 'Error', $validator->errors());
            }
            //store request in db
            $employee->update([
                'name' => $request->name,
                'government_id' => $request->government_id,
                'hierarchical_id' => $request->hierarchical_id
            ]);
            if($request->has('img')){
                //store img in file
                $file_extentions = $request->img->getClientOriginalExtension();
                $file_name = uniqid('', true) . '.' . $file_extentions;
                $request->img->move("gallary", $file_name);
                $img = Gallary::select('*')->where('employee_id', $id)->first();
                $img->update([
                    'name' => $file_name,
                ]);
            }
            return $this->returnSuccess(200, 'this employee is updated succssfuly' );

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function getAll(){
        try{
            $employee = Employee::with('gallary')->select("*")->get();
            
            if($employee->count() >= 1){
                return $this->returnData(200, 'there is all employees', $employee);
            }
            return $this->returnError(422, 'sorry this is no data');
        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function getOne($id){
        try{
            /*$employee = Employee::find($id);
            if(! $employee){
                return $this->returnError(422, 'sorry this id not exists');
            }   
            //$getOneEmployee = $employee->with(['gallary', 'hierarchical'])->select("*")->first();
            $getValueOfParent = $employee->hierarchical->parent;
            if($getValueOfParent == null){
                $getEmployeeWithChilds = $employee->with('hierarchical')->where( 'hierarchical_id', '>=', 1)->orderBy('hierarchical_id')->paginate(PAGINATION_COUNT);
                return $this->returnData(200, 'this is  employee', $getEmployeeWithChilds);
            }
            $getEmployeeWithChilds2 = $employee->with('hierarchical')->where( 'hierarchical_id', '>', $getValueOfParent)->orderBy('hierarchical_id')->paginate(PAGINATION_COUNT);
            return $this->returnData(200, 'this is  employee', $getEmployeeWithChilds2);*/
            return Hierarchical::with('children')->withDepth()->get()->toFlatTree();
            // $new = "WITH RECURSIVE tree_view AS (
            //     SELECT id,
            //          parent,
            //          position,
            //          0 AS level,
            //          CAST(id AS varchar(50)) AS order_sequence
            //     FROM hierarchical_structure
            //     WHERE parent IS NULL
                 
            // UNION ALL
             
            //     SELECT parent.id,
            //          parent.parent,
            //          parent.position,
            //          level + 1 AS level,
            //          CAST(order_sequence || '_' || CAST(parent.id AS VARCHAR (50)) AS VARCHAR(50)) AS order_sequence
            //     FROM hierarchical_structure parent
            //     JOIN tree_view tv
            //       ON parent.parent = tv.id
            // )
             
            // SELECT
            //    RIGHT('------------',level*3) || position 
            //      AS parent_child_tree
            // FROM tree_view
            // ORDER BY order_sequence";
            //return $result= DB::select(DB::raw($new));
            


        }catch(\Exception $ex){
            return $ex;
            return $this->returnError(422, 'sorry this is an error');
        }
    }

    
    
    public function destroy($id){
        try{
            $employee = Employee::find($id);
            if($employee){
                //delete from folder
                $img = Gallary::select('*')->where('employee_id', $id)->first();
                $image = Str::afterLast($img->name, 'assets/');
                $image = base_path('public\gallary'. '\\' . $image);
                unlink($image); //delete photo from folder
                //delete img from table gallary
                $employee->gallary()->delete();
                //delete from database
                $employee->delete();
                return $this->returnSuccess(200, 'This employee successfuly Deleted');

            }
            return $this->returnError(422, 'sorry this id not exists');

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');

        }
    }
}
