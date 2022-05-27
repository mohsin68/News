<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\AllTrait;
use App\Models\Newsimage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsimagesController extends Controller
{
    use AllTrait;
    public function store(Request $request){
        try {
            //validation
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'name.*' => 'image|mimes:jpeg,png,jpg,gif,svg'
            ]);
     
            if ($validator->fails()) {
                return $this->returnError(422, 'sorry this is an error', 'Error', $validator->errors());
            }
            // save photo in folder
                        // insert into db 
            if($request->hasFile('name')){
                foreach($request->name as $src){
                    $file_extentions = $src->getClientOriginalExtension();
                    $file_name = uniqid('', true) . '.' . $file_extentions;
                    $src->move("newsimages", $file_name);
                    Newsimage::create([
                        'name' => $file_name,
                        'news_i_id' => $request->news_i_id
                    ]);
                }
                return $this->returnSuccess(200, 'photo is added succssfuly' );


            }
            return $this->returnError('422', 'there is an error in uploading');

        } catch (\Exception $ex) {
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function getAll($id){
        try{
            $newsimg = Newsimage::select("*")->where('news_i_id', $id)->get();
            if($newsimg->count() >= 1){
                return $this->returnData(200, 'there is all images', $newsimg);
            }
            return $this->returnError(422, 'sorry this is not exists');

        }
        catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function destroy($id){
        try{
            $newsimg = Newsimage::find($id);
            if($newsimg){
                //delete from file
            $image = Str::afterLast($newsimg->name, 'assets/');
            $image = base_path('public\newsimages'. '\\' . $image);
            unlink($image); //delete photo from folder
            //delete from database
            $newsimg->delete();
            return $this->returnSuccess(200, 'This img successfuly Deleted');

            }
            return $this->returnError(422, 'sorry this id not exists');

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');

        }
    }
}
