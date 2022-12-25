<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllTrait;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    use AllTrait;
    public function store(Request $request){
        try{
            //validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:191',
                'appointment_time' => 'required|date_format:"H:i',
                'appointment' => "required|after:date('Y-m-d')",
                'time' => 'required|integer|min:1|max:24',
                'user_id' => 'required',
                'user_id.*' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return $this->returnError(422, 'sorry this is an error', 'Error', $validator->errors());
            }
            Exam::create([
                'name' => $request->name,
                'appointment_time' =>  $request->appointment_time,
                'appointment' => $request->appointment,
                'time' => $request->time . " hours",
            ]);
            $users = $request->user_id;
            foreach ($users as $user){
                Exam::create([
                    'user_id' => $user,
                ]);
            }
            return $this->returnSuccess(200, 'this Exam is added succssfuly' );

        }catch(\Exception $ex){
            return $ex;
            return $this->returnError(422, 'sorry this is an error');
        }

    }
    public function update(Request $request, $id){
        try{
            //find exam
            $exam = Exam::find($id);
            if(! $exam){
                return $this->returnError(422, 'sorry this is not exists');
            }
            //validate request
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:191',
                'appointment_time' => 'required|date_format:"H:i',
                'appointment' => "required|after:date('Y-m-d')",
                'time' => 'required|integer|min:1|max:24',
                'user_id' => 'required|integer'
            ]);
            if ($validator->fails()) {
                return $this->returnError(422, 'sorry this is an error in validation', 'Error', $validator->errors());
            }
            //store request in db
            $exam->update([
                'name' => $request->name,
                'appointment_time' =>  $request->appointment_time,
                'appointment' => $request->appointment,
                'time' => $request->time . " hours",
                'user_id' => $request->user_id
            ]);

            return $this->returnSuccess(200, 'this exam is updated succssfuly' );

        }catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }
    }
    public function getAllExams(){
        try{
            $exams = Exam::get();
            return $this->returnData(200, 'there is all exams', $exams);
        }
        catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }

    }
    public function getOneExam($id){
        try{
            //find exam
            $exam = Exam::with(['questions.answer'])->find($id);
            if(! $exam){
                return $this->returnError(422, 'sorry this is not exists');
            }
            return $this->returnData(200, 'there is exam with his all questions and answer', $exam);
        }
        catch(\Exception $ex){
            return $this->returnError(422, 'sorry this is an error');
        }

    }
    public function destroy($id){
        try{
            $exam = Exam::find($id);
            if($exam){
                // foreach($exam->questions() as $question){
                    
                //     $question->answer()->delete();
                // }
            $exam->with(['questions.answer'])->delete();
            $exam->questions()->delete();
            //delete exam from database
            $exam->delete();
            return $this->returnSuccess(200, 'This exam successfuly Deleted');

            }
            return $this->returnError(422, 'sorry this id not exists');

        }catch(\Exception $ex){
            return $ex;
            return $this->returnError(422, 'sorry this is an error');

        }
    }
}
