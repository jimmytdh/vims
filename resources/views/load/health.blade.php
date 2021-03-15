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
    @foreach($questions as $key => $value)
        <?php
            $question = 'question_'.str_pad($key+1,2,0,STR_PAD_LEFT);
            $ans = $data->$question;

            $age = \Carbon\Carbon::parse($data->birthdate)->diff(\Carbon\Carbon::now())->format('%y');
                if($age>16 && $key==0)
                    $ans = '01_Yes';
        ?>
        @if($data->sex=='02_Male' && ($key==13 || $key==14))
            @continue
        @endif
    <div class="form-group mt-2">
        <label>{{ $value }}</label>
        @if($key==8 || $key==16)
        <input type="text" value="{{ $data->$question }}" name="{{ $question }}" class="form-control">
        @else
        <select name="{{ $question }}" class="custom-select">
            <option value="">Select...</option>
            <option value="01_Yes" {{ ($ans=='01_Yes') ? 'selected':'' }}>Yes</option>
            <option value="02_No" {{ ($ans=='02_No') ? 'selected':'' }}>No</option>
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
