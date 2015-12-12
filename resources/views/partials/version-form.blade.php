<div class="form-group">
    {!! Form::label('version', 'Version*', ['class' => 'col-sm-2 control-label form-label']) !!}

    <div class="col-sm-3">
        {!! Form::text('version', old('version'), ['class' => 'form-control', 'placeholder' => '1.1.3']) !!}

    </div>
</div>

<div class="form-group">
    {!! Form::label('beta', 'In Beta', ['class' => 'col-sm-2 control-label form-label']) !!}
    <div class="col-sm-3">
        {!! Form::checkbox('beta', 'true', old("beta")) !!}
    </div>
</div>

{!! Form::myInput('video_link', 'Gameplay Link', 'https://www.youtube.com/watch?v=e-ORhEE9VVg') !!}

<div class="form-group">
    {!! Form::label('image1', 'Screenshots*', ['class' => 'col-sm-2 control-label form-label']) !!}

    <span>
        {!! Form::myImageWithThumbnail('image1') !!}
    </span>
    <span>
    {!! Form::myImageWithThumbnail('image2') !!}
        </span>
    <div class="col-sm-4">
        <p class="small add-game-explanation">
            <b>Recommended:</b> 720px by 405px<br>
            <b>Accepted Types:</b> PNG, JPEG, GIF<br>
            <b>Max File Size:</b> 2 MB
        </p>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2"></div>
    {!! Form::myImageWithThumbnail('image3') !!}
    {!! Form::myImageWithThumbnail('image4') !!}
</div>

<div class="form-group">
    {!! Form::label('changes', 'Changes Made This Version', ['class' => 'col-sm-2 control-label form-label']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('changes', old('changes'), ['class' => 'form-control', 'rows' => 7]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('upcoming_features', 'Upcoming Features', ['class' => 'col-sm-2 control-label form-label']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('upcoming_features', old('upcoming_features'), ['class' => 'form-control', 'rows' => 7]) !!}
    </div>
</div>

