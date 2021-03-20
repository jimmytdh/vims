<form action="{{ url('/vas/health/'.$id) }}" method="post" id="healthForm">
    <input type="hidden" value="{{ $data->id }}" name="pk">
    <div class="form-group">
        <label>Deferral</label>
        <select name="deferral" class="custom-select">
            <option value="">None</option>
            @foreach($deferral as $def)
            <option @if($data->deferral == $def->name) selected @endif>{{ $def->name }}</option>
            @endforeach
        </select>
    </div>
    <?php
        $x[4] = null;
        $x[6] = null;
        $x[8] = null;
        $x[16] = null;
    ?>
    @foreach($questions as $key => $value)
        <?php
            $question = 'question_'.str_pad($key+1,2,0,STR_PAD_LEFT);
            $ans = $data->$question;
            $x[$key+1] = $ans;
            $age = \Carbon\Carbon::parse($info->birthdate)->diff(\Carbon\Carbon::now())->format('%y');
                if($age<16 && $key==0)
                    $ans = '01_Yes';

            $class = "";
            if($question=='question_05' && $x[4] == '01_Yes')
                $class='hidden';
           else if($question=='question_07' && $x[6] == '01_Yes')
                $class='hidden';
           else if($question=='question_09' && $x[8] == '01_Yes')
               $class='hidden';
           else if($question=='question_17' && $x[16] == '01_Yes')
               $class='hidden';
           else if($question=='question_18' && $x[16] == '01_Yes')
               $class='hidden';
        ?>
        @if($info->sex=='02_Male' && $key==13)
            @continue
        @elseif($info->sex=='02_Male' && $key==14)
            @continue
        @endif
    <div class="form-group mt-2 div_{{ $question }} {{ $class }}">
        <label>{{ $value }}</label>
        @if($key==8 || $key==16)
            <input type="text" value="{{ $data->$question }}" name="{{ $question }}" class="form-control">
        @elseif($key==0 ||$key==4 || $key==6 || $key==14)
            <select name="{{ $question }}" class="custom-select {{ $question }}">
                <option value="">Select...</option>
                <option value="01_Yes" {{ ($ans=='01_Yes') ? 'selected':'' }}>Yes</option>
                <option value="02_No" {{ ($ans=='02_No') ? 'selected':'' }}>No</option>
            </select>
        @else
            <select name="{{ $question }}" class="custom-select {{ $question }}">
                <option value="">Select...</option>
                <option value="02_No" {{ ($ans=='02_No') ? 'selected':'' }}>Yes</option>
                <option value="01_Yes" {{ ($ans=='01_Yes') ? 'selected':'' }}>No</option>
            </select>
        @endif
    </div>
    @endforeach

    <hr>
    <div class="form-row">
        <div class="form-group col-sm-6">
            <button type="submit" class="btn btn-block btn-success">Submit</button>
        </div>
        <div class="form-group col-sm-6">
            <button type="button" data-dismiss="modal" class="btn btn-block btn-default">Close</button>
        </div>
    </div>
</form>
