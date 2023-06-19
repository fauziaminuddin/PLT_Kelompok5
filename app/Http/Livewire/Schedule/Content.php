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

        //mengambil data dari table dimasukkan pada variable
            //Subjek
            $subjectIds = $timetableData->pluck('subject_id')->unique()->all();
            $timetableSubjects = TimetableSubject::whereIn('id', $subjectIds)->get();
            $timetableData = $this->updateSubject($timetableData, $timetableSubjects);
        
            //Room
            $roomIds = $timetableData->pluck('room_id')->unique()->all();
            $timetableRoom = TimetableRoom::whereIn('id', $roomIds)->get();
            $timetableData = $this->updateRoom($timetableData, $timetableRoom);

            //student
            $studentIds = $timetableData->pluck('student_id')->unique()->all();
            $timetableStudent = TimetableStudent::whereIn('id', $studentIds)->get();
            $timetableData = $this->updateStudent($timetableData, $timetableStudent);

            //faculty
            $facultyIds = $timetableData->pluck('code')->unique()->all();
            $timetableFaculty = TimetableFaculty::whereIn('id', $facultyIds)->get();
            $timetableData = $this->updateFaculty($timetableData, $timetableFaculty);
            
            //tags
            $tagIds = $timetableData->pluck('code')->unique()->all();
            $timetableTag = TimetableTags::whereIn('id', $tagIds)->get();
            $timetableData = $this->updateTag($timetableData, $timetableTag);
            
        }
        return view('livewire.schedule.content', [
            'studyPrograms' => $studyPrograms,
            'timetableData' => $timetableData,
        ]);
    }

    //mengganti subjek, code, dan credit matkul
    public function updateSubject($timetableData, $timetableSubjects){
        return $timetableData->map(function ($data) {
            $subject = timetableSubject::Where('id', $data->subject_id)->first();

            if ($subject) {
                $data->subject_id = $subject->name;
                $data->code = $subject->code;
                $data->credit = $subject->credit;

            $studentSet = TimetableStudentSets::where('schedule_id', $data->id)->first();
                if ($studentSet) {
                    $data->student_id = $studentSet->student_id;
                }

            $teaching = TimetableTeaching::where('schedule_id', $data->id)->first();
                if ($teaching) {
                    $data->faculty_id = $teaching->faculty_id;
                }

            $tags = TimetableActivity::where('schedule_id', $data->id)->first();
                if ($tags) {
                    $data->tag_id = $tags->tag_id;
                }
            }
        return $data;
        });
        
    }

    //mengganti data dari table room
    public function updateRoom($timetableData, $timetableRoom){
        return $timetableData->map(function ($data) {
            $room = timetableRoom::Where('id', $data->room_id)->first();

            if ($room) {
                $data->room_id = $room->name;
                $data->room_code = $room->code;
            }
        return $data;
        });
    }
    //mengganti data dari table student
    public function updateStudent($timetableData, $timetableStudent){
        return $timetableData->map(function ($data) {
            $student = timetableStudent::Where('id', $data->student_id)->first();

            if ($student) {
                $data->student_id = $student->code;
            }
        return $data;
        });
    }

    //mengganti data dari table faculty
    public function updateFaculty($timetableData, $timetableFaculty){
        return $timetableData->map(function ($data) {
            $faculty = timetableFaculty::Where('id', $data->faculty_id)->first();

            if ($faculty) {
                $data->teaching_id = $faculty->code;
                $data->upi_code = $faculty->upi_code;
            }
        return $data;
        });
    }

    //mengganti data dari table Tags
    public function updateTag($timetableData, $timetableTag){
        return $timetableData->map(function ($data) {
            $tags = timetableTags::Where('id', $data->tag_id)->first();

            if ($tags) {
                $data->tag_id = $tags->code;
            }
        return $data;
        });
    }
}

