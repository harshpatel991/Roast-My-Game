<div class="form-group">
    {!! Form::label('version', 'Version*', ['class' => 'col-sm-2 control-label form-label']) !!}

    <div class="col-sm-3">
        {!! Form::text('version', old('version'), ['class' => 'form-control', 'placeholder' => '1.1.3']) !!}

    </div>
</div>

<div class="form-group">
    {!! Form::label('beta', 'In Beta', ['class' => 'col-sm-2 col-xs-3 control-label form-label']) !!}
    <div class="col-xs-3">
        {!! Form::checkbox('beta', 'true', old("beta")) !!}
    </div>
</div>

{!! Form::myInput('video_link', 'Gameplay Video', 'https://www.youtube.com/watch?v=e-ORhEE9VVg') !!}

<div class="form-group">
    {!! Form::label('image1', 'Screenshots*', ['class' => 'col-sm-2 control-label form-label']) !!}

    {!! Form::myImageWithThumbnail('image1') !!}
    {!! Form::myImageWithThumbnail('image2') !!}

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
    <a class="btn btn-primary col-sm-offset-2" role="button" data-toggle="collapse" href="#collapsePlayGameLinks">Add Download Game Links <i class="icon-down-dir"></i></a>
    <div class="collapse" id="collapsePlayGameLinks" style="padding-top: 10px;">
        <div class="col-sm-offset-2">
            <p>If your game is avaiable to play, add links to download your game</p>
        </div>
        {!! Form::myInput('link_platform_pc', 'PC', '') !!}
        {!! Form::myInput('link_platform_mac', 'Mac', '') !!}
        {!! Form::myInput('link_platform_ios', 'iOS', '') !!}
        {!! Form::myInput('link_platform_android', 'Android', '') !!}
        {!! Form::myInput('link_platform_unity', 'Unity Web', '') !!}
        {!! Form::myInput('link_platform_other', 'Other Web', '') !!}

    </div>
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

