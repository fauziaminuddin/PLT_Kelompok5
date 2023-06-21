<?php

namespace App\Http\Livewire\Schedule;
use App\Models\Arsys\StudyProgram;
use App\Models\timetableSchedule;
use App\Models\timetableSubject;
use App\Models\timetableRoom;
use App\Models\timetableStudent;
use App\Models\timetableStudentSets;
use App\Models\timetableTeaching;
use App\Models\timetableFaculty;
use App\Models\timetableActivity;
use App\Models\timetableTags;

use Livewire\Component;

class Content extends Component
{
    public $selectedProgram = null;

    public function render()
    {
        $studyPrograms = StudyProgram::all();
        $timetableData = [];

        //mengatur respon dari dropdown (select2), nilai yang dipilih disimpan pada variable
        if ($this->selectedProgram) {
            if ($this->selectedProgram == 'PTE') {
                $timetableData = TimetableSchedule::where('program_id', 1)->get();
            } elseif ($this->selectedProgram == 'TE') {
                $timetableData = TimetableSchedule::where('program_id', 2)->get();
            } elseif ($this->selectedProgram == 'PTOIR') {
                $timetableData = TimetableSchedule::where('program_id', 3)->get();
            }

        //mengambil data dari timetable
            //Subjek
            $scheduleIds = $timetableData->pluck('id')->all();                           //mengambil id dari timetabledata (yg dipilih)
            $timetableSchedule = TimetableSchedule::whereIn('subject_id', $scheduleIds)->get();  //mengambil data dari table
            $timetableData = $this->updateSchedule($timetableData, $timetableSchedule) ;  //memperbarui subject_id dengan informasi dari tablesubject
        
                        
        }
        return view('livewire.schedule.content', [
            'studyPrograms' => $studyPrograms,
            'timetableData' => $timetableData,
        ]);
    }

    //mengganti nilai pada tabel
    public function updateSchedule($timetableData, $timetableSchedule){
        return $timetableData->map(function ($data) {
            //untuk subjek, code, credit
            $subject = TimetableSubject::Where('id', $data->subject_id)->first();

            if ($subject) {
                $data->subject_id = $subject->name;
                $data->code = $subject->code;
                $data->credit = $subject->credit;
            //student
            $studentSet = TimetableStudentSets::where('schedule_id', $data->id)->first();
                if ($studentSet) {
                    $data->student_id = $studentSet->student_id;
                    //mengganti nilai dari TimetableStudentSets dengan TimetableStudent
                    $student = TimetableStudent::Where('id', $data->student_id)->first();
                        if ($student) {
                            $data->student_id = $student->code;
                        }
                }
            //Teacher
            $teaching = TimetableTeaching::where('schedule_id', $data->id)->first();
                if ($teaching) {
                    $data->faculty_id = $teaching->faculty_id;

                    $faculty = timetableFaculty::Where('id', $data->faculty_id)->first();
                        if ($faculty) {
                            $data->teaching_id = $faculty->code;
                            $data->upi_code = $faculty->upi_code;
                        }
                }
            //tags
            $tags = TimetableActivity::where('schedule_id', $data->id)->first();
                if ($tags) {
                    $data->tag_id = $tags->tag_id;

                    $tags = timetableTags::Where('id', $data->tag_id)->first();
                        if ($tags) {
                            $data->tag_id = $tags->code;
                        }
                }
            //room
            $room = TimetableRoom::Where('id', $data->room_id)->first();
                if ($room) {
                    $data->room_id = $room->name;
                    $data->room_code = $room->code;
                }
            }
        return $data;
        });
        
    }
    
    //mengganti data dari table room
/*    public function updateRoom($timetableData, $timetableRoom){
        return $timetableData->map(function ($data) {
            $room = TimetableRoom::Where('id', $data->room_id)->first();

            if ($room) {
                $data->room_id = $room->name;
                $data->room_code = $room->code;
            }
        return $data;
        });
    }*/

    //mengganti data dari table student
    /*public function updateStudent($timetableData, $timetableStudent){
        return $timetableData->map(function ($data) {
            $student = TimetableStudent::Where('id', $data->student_id)->first();

            if ($student) {
                $data->student_id = $student->code;
            }
        return $data;
        });
    }*/

    //mengganti data dari table faculty
    /*public function updateFaculty($timetableData, $timetableFaculty){
        return $timetableData->map(function ($data) {
            $faculty = timetableFaculty::Where('id', $data->faculty_id)->first();

            if ($faculty) {
                $data->teaching_id = $faculty->code;
                $data->upi_code = $faculty->upi_code;
            }
        return $data;
        });
    }*/

    //mengganti data dari table Tags
    /*public function updateTag($timetableData, $timetableTag){
        return $timetableData->map(function ($data) {
            $tags = timetableTags::Where('id', $data->tag_id)->first();

            if ($tags) {
                $data->tag_id = $tags->code;
            }
        return $data;
        });
    }*/
}

