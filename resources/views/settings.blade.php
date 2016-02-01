@extends('app')

@section('page-title')Settings - {{Config::get('app.name')}}@endsection

@section('navbar')
    @include('partials/fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">

                    @include('partials.display-input-error')

                    <h4>Settings</h4>
                    <h6 class="subheading subheading-color">Profile Image</h6>
                    {!! Form::open(array('url' => '/settings/save-profile-image', 'class'=>'form-horizontal', 'files'=> true)) !!}
                        <div class="row">
                            <div class="col-md-offset-3 col-md-2 col-sm-3 col-sm-offset-2 col-xs-3">
                                <div class="embed-responsive embed-responsive-1by1">
                                    <div class="embed-responsive-item">
                                        {!! $user->getProfileImage('100%', 'user-profile-default-font-responsive') !!}
                                    </div>
                                </div>
                            </div>
                            <div class=" col-sm-4 col-xs-9">
                                {!! Form::file('profile_image', ['class' => 'form-control', 'accept' => 'image/*'])!!}

                                <button id="save-profile" class="btn btn-success btn-block" style="margin-top: 10px;">Save</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <hr>
                    <h6 class="subheading subheading-color">Change Password</h6>
                    {!! Form::open(array('url' => '/settings/save-password-change', 'class'=>'form-horizontal')) !!}
                        <div class="form-group">
                            {!! Form::label('current-password', 'Current Password', ['class' => 'col-sm-3 form-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::password('current-password', ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', 'New Password', ['class' => 'col-sm-3  form-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('password_confirmation', 'Confirm New Password', ['class' => 'col-sm-3 form-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-offset-4 col-sm-4">
                                <button id="save-password" class="btn btn-success btn-block">Save</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <hr>
                    <h6 class="subheading subheading-color">Email Settings</h6>
                    {!! Form::open(array('url' => '/settings/save-email-change', 'class'=>'form-horizontal')) !!}
                        <div class="form-group">
                            {!! Form::label('mail_roasts', 'Roasts to my game', ['class' => 'col-sm-6 form-label']) !!}
                            <div class="col-xs-1">
                                {!! Form::checkbox('mail_roasts', 'true', $user->mail_roasts) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('mail_comments', 'Replies to my comment', ['class' => 'col-sm-6 form-label']) !!}
                            <div class="col-xs-1">
                                {!! Form::checkbox('mail_comments', 'true', $user->mail_comments) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('mail_progress_reminders', 'Progress update reminders', ['class' => 'col-sm-6 form-label']) !!}
                            <div class="col-xs-1">
                                {!! Form::checkbox('mail_progress_reminders', 'true', $user->mail_progress_reminders) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('mail_site_updates', 'Monthly website updates', ['class' => 'col-sm-6 form-label']) !!}
                            <div class="col-xs-1">
                                {!! Form::checkbox('mail_site_updates', 'true', $user->mail_site_updates) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-offset-4 col-sm-4">
                                <button id="save-email" class="btn btn-success btn-block">Save</button>
                            </div>
                        </div>
                    {!! Form::close() !!}

                    <br>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="col-md-8 col-md-offset-2">
        @include('partials/footer')
    </div>
@endsection