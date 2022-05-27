<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\AllTrait;
use App\Models\News;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    use AllTrait;
    public function store(Request $request){
        try{
            //validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:191',
                'desc' => 'required',
                'user' => 'required|max:191',
                'link' => 'required|url',
                'governorate_id' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return $this->returnError(422, 'sorry this is an error in validation', 'Error', $validator->errors());
            }
            News::create([
                'name' => $request->name,
                'desc' => $request->desc,
                'user' => $request->user,
                'link' => $request->link,
                'governorate_id' => $request->governorate_id
            ]);
            return $this->returnSuccess(200, 'this News is added succssfuly' );

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function changeStatus($id){
        try{
            $status = News::find($id);
            if(!$status){
                return $this->returnError(422, 'sorry this is not exists');
            }
            $newstatus = $status->status == 0? 1 : 0;
            $status->update(['status' => $newstatus]);
            return $this->returnSuccess(200, 'this status is changed succssfuly' );

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function changeConst($id){
        try{
            $const = News::find($id);
            if(!$const){
                return $this->returnError(422, 'sorry this is not exists');
            }
            $newstatus = $const->const == 0? 1 : 0;
            $const->update(['const' => $newstatus]);
            return $this->returnSuccess(200, 'this const is changed succssfuly' );

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    
    public function getAllNewsConst(){
        try{
            $news = News::with(['governorate', 'source', 'newsimg', 'words'])->select("*")->where(['status' => 0 , 'const' => 1])->paginate(PAGINATION_COUNT);
            
            if($news->count() >= 1){
                return $this->returnData(200, 'there is all news', $news);
            }
            return $this->returnError(422, 'sorry this is not exists');

        }
        catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function getAllNews(){
        try{
            $news = News::with(['governorate', 'source', 'newsimg', 'words'])->select("*")->where('status', 0)->paginate(PAGINATION_COUNT);
            
            if($news->count() >= 1){
                return $this->returnData(200, 'there is all news', $news);
            }
            return $this->returnError(422, 'sorry this is not exists');

        }
        catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function destroy($id){
        try{
            $news = News::find($id);
            if($news){
            //delete newsimages 
            $news->newsimg()->delete();
            //delete source 
            $news->source()->delete();
            //delete words 
            $news->words()->delete();
      
            //delete from database
            $news->delete();
            return $this->returnSuccess(200, 'This news successfuly Deleted');

            }
            return $this->returnError(422, 'sorry this id not exists');

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');

        }
    }
}
