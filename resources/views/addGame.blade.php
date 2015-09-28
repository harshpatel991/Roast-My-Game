@extends('app')

@section('page-title')
    {{Config::get('app.name')}}
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 form-background">
                <h1>Add Your Game</h1>
                {!! Form::open(array('route' => 'add-game', 'class'=>'form-horizontal', 'files'=>true, 'id' => 'add-game')) !!}
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-6">
                            <input class="form-control" id="title" name="title" placeholder="Title">
                        </div>
                        <div class="col-sm-4">
                            <p class="small add-game-explanation">The title of your game.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="developer-name" class="col-sm-2 control-label">Developer Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="developer-name" name="developer-name" placeholder="Developer Name"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail" class="col-sm-2 control-label">Thumbnail</label>
                        <div class="col-sm-6">
                            <input type="file" id="thumbnail" name="thumbnail">
                        </div>
                        <div class="col-sm-4">
                            <p class="small add-game-explanation">This image will be displayed when showing your game on another part of the site.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="game-file" class="col-sm-2 control-label">Game file</label>
                        <div class="col-sm-6">
                            <input class="form-control" id="game-file" name="game-file" placeholder=".unityfile Link">
                        </div>
                        <div class="col-sm-4">
                            <p class="small add-game-explanation">Public link to your .unityfile. You can upload your game to DropBox. Instructions here.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="version" class="col-sm-2 control-label">Version</label>
                        <div class="col-sm-6">
                            <input class="form-control" id="version" name="version" placeholder="Version">
                        </div>
                        <div class="col-sm-4">
                            <p class="small add-game-explanation">Current version of your game. Example: 1.1.3</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="beta" class="col-sm-2 control-label">In Beta?</label>
                        <div class="col-sm-6">
                            <input type="checkbox" id="beta" name="beta" placeholder="Beta">
                        </div>
                        <div class="col-sm-4">
                            <p class="small add-game-explanation">Is your game currently in beta?</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="genre" class="col-sm-2 control-label">Genre</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="genre" name="genre">
                                <option value="">Select Genre</option>
                                <option value="action">Action</option>
                                <option value="platformer">Platformer</option>
                                <option value="rouge-like">Rouge-Like</option>
                                <option value="fps">FPS</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" rows="4" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="controls" class="col-sm-2 control-label">Controls</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" rows="4" id="controls" name="controls"></textarea>
                        </div>
                        <div class="col-sm-4">
                            <p class="small add-game-explanation">Let your players know how to play your game.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-6">
                            <input class="form-control" id="email" name="email" placeholder="Email"></input>
                        </div>
                        <div class="col-sm-4">
                            <p class="small add-game-explanation">This will not be shared with anyone.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Add Game!</button>
                        </div>
                    </div>
                    {!! Form::close() !!}


            </div>

            </div>

        </div>
    </div>

@endsection