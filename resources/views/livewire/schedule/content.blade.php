<div>
    <div>
        <select class="form-control my-dropdown" style="width: 500px; cursor: pointer" wire:model="selectedProgram" id="study_program">
            <option value="">-- Select Program --</option>
            @foreach($studyPrograms as $program)
                <option value="{{ $program->abbrev }}">{{ $program->code }} - {{ $program->description }}</option>
            @endforeach
        </select>
    </div>

    @if($selectedProgram)
    <br>
    <div class="result">
        <p>
            <span><b>Code</b></span>
            : {{ $studyPrograms->where('abbrev', $selectedProgram)->first()->code }}
        </p>
        <p>
            <b>Study Program </b>
            : {{ $studyPrograms->where('abbrev', $selectedProgram)->first()->description }}
        </p>

        <br>
        @if($timetableData->isEmpty())
            <p>No data available.</p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Teacher</th>
                    <th>Subject</th>
                    <th>Credit</th>
                    <th>Student</th>
                    <th>Room</th>
                    <th>Day-Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $counter = 1 
                @endphp
                @foreach ($timetableData as $index => $data)
                    <tr>
                        <td>{{ $counter + 1 }}</td>
                        <td style="word-wrap: break-word; max-width: 50px;">
                            {{ $data->code }}</td>    
                        <td style="word-wrap: break-word; max-width: 90px;">
                            {{ $data->upi_code }} - {{ $data->teaching_id }}
                        </td>
                        <td style="word-wrap: break-word; max-width: 170px;">
                            {{ $data->subject_id }}
                            <br><br>
                            <b>Tags: </b>
                            {{ $data->tag_id }}

                        </td>
                        <td style="word-wrap: break-word; max-width: 50px;">
                            {{ $data->credit }}</td>
                        <td style="word-wrap: break-word; max-width: 80px;">
                            {{ $data->student_id }}</td>
                        <td style="word-wrap: break-word; max-width: 120px;">
                            {{ $data->room_id }} <br>
                            {{ $data->room_code }}</td>
                        <td style="word-wrap: break-word; max-width: 70px;">
                            {{ date('l', strtotime($data->daytime)) }}<br>
                            {{ date('H:i', strtotime($data->daytime)) }}
                        </td>
                        <td><a style="cursor: pointer;">                            
                            <i class="fa fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    @endif
</div>


<style>
    .result p span {
        margin-right: 70px;
    }
</style>
