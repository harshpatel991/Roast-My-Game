{!! Form::myInput('title', 'Title*', '', old('title'), $game->title) !!}

<div class="form-group">
    {!! Form::label('genre', 'Genre*', ['class' => 'col-sm-2 control-label form-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('genre', App\Game::$genres, old('genre')!='' ? old('genre') : $game->genre, ['class' => 'form-control']) !!}
    </div>
</div>


@if(isset($isEdit) ? !$isEdit : true)
    <div class="form-group">
        {!! Form::label('thumbnail', 'Thumbnail*', ['class' => 'col-sm-2 control-label form-label']) !!}
        <div class="col-sm-6">
            <div class="embed-responsive embed-responsive-16by9">
                <img class="embed-responsive-item" id="thumbnail-preview" src="{{ secure_url('/images/placeholder.jpg') }}"/>
            </div>
            {!! Form::file('thumbnail', ['class' => 'form-control', 'accept' => 'image/*', 'id' => 'thumbnail']) !!}
        </div>
        <div class="col-sm-4">
            <p class="small add-game-explanation">
                This image will be used when your game is displayed on the homepage.<br>
                <b>Required 16x9 Aspect Ratio</b><br>
                <b>Accepted Types:</b> PNG, JPEG, GIF<br>
                <b>Max File Size:</b> 2 MB
            </p>
        </div>
    </div>
@endif

<div class="form-group">
    {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label form-label']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('description', old('description')!='' ? old('description') : $game->description, ['class' => 'form-control', 'rows' => 4]) !!}
    </div>
</div>

<div class="form-group">
    <a class="btn btn-info col-sm-offset-2" role="button" data-toggle="collapse" href="#collapseSocialLinks">Add Social Links <i class="icon-down-dir"></i></a>
    <div class="collapse" id="collapseSocialLinks" style="padding-top: 10px;">
        {!! Form::myInput('link_social_greenlight', 'Greenlight', '', old('link_social_greenlight'), $game->link_social_greenlight) !!}
        {!! Form::myInput('link_social_website', 'Website', '', old('link_social_website'), $game->link_social_website) !!}
        {!! Form::myInput('link_social_twitter', 'Twitter', '', old('link_social_twitter'), $game->link_social_twitter) !!}
        {!! Form::myInput('link_social_youtube', 'YouTube', '', old('link_social_youtube'), $game->link_social_youtube) !!}
        {!! Form::myInput('link_social_google_plus', 'Google+', '', old('link_social_google_plus'), $game->link_social_google_plus) !!}
        {!! Form::myInput('link_social_facebook', 'Facebook', '', old('link_social_facebook'), $game->link_social_facebook) !!}
    </div>
</div>
