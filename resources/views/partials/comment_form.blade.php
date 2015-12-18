<form action="{{ $action }}" method="POST">
    {!! csrf_field() !!}

    {{--<div class="small-grey-box">--}}

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="positive">Favorite aspect</label>
                    {!! Form::select('positive', App\Feedback::$feedbackCategories, old('positive'), ['class' => 'form-control']) !!}

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="negative">Needs most work</label>
                    {!! Form::select('negative', App\Feedback::$feedbackCategories, old('negative'), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <label for="exampleInputEmail1">Comments</label>
                    <textarea class="form-control" name="body" rows="4"></textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-light-blue btn-sm" type="submit">Reply</button>
        </div>

    {{--</div>--}}


</form>