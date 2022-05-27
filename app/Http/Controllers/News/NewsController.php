<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\AllTrait;
use App\Models\News;
use App\Models\Word;
use App\Models\Idimage;
use App\Models\Source;
use App\Models\Newsimage;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    use AllTrait;
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:191',
                'desc' => 'required',
                'user' => 'required|max:191',
                'link' => 'required|url',
                'governorate_id' => 'required|integer',
                'wordname' => 'required|max:191',
                'sourcelinks' => 'required|array',
                'sourcelinks.*' => 'required|url',
                'id_image' => 'required',
                'id_image.*' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return $this->returnError(422, 'sorry this is an error in validation', 'Error', $validator->errors());
            }
            News::create([
                'name' => $request->name,
                'desc' => $request->desc,
                'user' => $request->user,
                'link' => $request->link,
                'governorate_id' => $request->governorate_id,
                'user_id' => auth()->user()->id
            ]);
            $lastNewOfUser = News::select('*')->where('user_id' , auth()->user()->id)->latest('id')->first();
            $words = $request->wordname;
            foreach ($words as $word){
                Word::create([
                    'wordname' => $word,
                    'news_w_id' => $lastNewOfUser->id
                ]);
            }
            $sources = $request->sourcelinks;
            foreach ($sources as $source){
                Source::create([
                    'sourcelinks' => $source,
                    'news_s_id' => $lastNewOfUser->id
                ]);
            }
            $idImgArrs = $request->id_image;
            foreach($idImgArrs as $idImgArr){
                Idimage::create([
                    'id_image' => $idImgArr,
                    'news_i_id' => $lastNewOfUser->id,
                ]);

            }

            return $this->returnSuccess(200, 'this News is added succssfuly' );

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    
    public function update(Request $request, $id){
        try{
            $news = News::find($id);
            if($news){
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:191',
                    'desc' => 'required',
                    'user' => 'required|max:191',
                    'link' => 'required|url',
                    'governorate_id' => 'required|integer',
                    'wordname' => 'required|max:191',
                    'sourcelinks' => 'required|array',
                    'sourcelinks.*' => 'required|url',
                    'id_image' => 'required',
                    'id_image.*' => 'required|integer',
                ]);
    
                if ($validator->fails()) {
                    return $this->returnError(422, 'sorry this is an error in validation', 'Error', $validator->errors());
                }
                
            
            $news->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'user' => $request->user,
                'link' => $request->link,
                'governorate_id' => $request->governorate_id,
            ]);
            $words = $request->wordname;
            foreach ($words as $word){
                $news->words()->update([
                    'wordname' => $word,
                ]);
            }
            $sources = $request->sourcelinks;
            foreach ($sources as $source){
                $news->source()->update([
                    'sourcelinks'=> $source,
                    
                ]);
            }
            $idImgArrs = $request->id_image;
            foreach($idImgArrs as $idImgArr){
                $news->idimage()->update([
                    'id_image' => $idImgArr,
                ]);

            }

            return $this->returnSuccess(200, 'this News is Updated succssfuly' );

            }
            return $this->returnError(422, 'sorry this is not exists');



        }catch(\Exception $ex){
            return $ex;
            //return $this->returnError(422, 'sorry this is an error');
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
            $news = News::with(['governorate', 'source', 'idimage', 'words'])->select("*")->where(['status' => 0 , 'const' => 1])->paginate(PAGINATION_COUNT);
            
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
            $news = News::with(['governorate', 'source', 'idimage', 'words'])->select("*")->where('status', 0)->paginate(PAGINATION_COUNT);
            
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
            //delete source 
            $news->source()->delete();
            //delete idimage 
            $news->idimage()->delete();
            //delete words 
            $news->words()->delete();
      
            //delete from database
            $news->delete();
            return $this->returnSuccess(200, 'This news successfuly Deleted');

            }
            return $this->returnError(422, 'sorry this id not exists');

        }catch(\Exception $ex){
            return $ex;
            //return $this->returnError(422, 'sorry this is an error');

        }
    }
}
