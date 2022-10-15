@extends('app')
@section('content')
    <form method="post" action="{{ isset($event) ? route('events.update', $event->id) : route('events.store')}}">
        @csrf
        @if(isset($event))
            @method('put')
        @endif
        <div class="modal-header">
            <h4 class="modal-title">{{isset($event) ? 'Update' : 'Add'}} Event</h4>
            @if($errors->any())
            <button type="button" class="close" id="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            @endif
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <p><strong>Opps Something went wrong</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif
        <div class="modal-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{isset($event) ? $event->name : ''}}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{isset($event) ? $event->slug : ''}}" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
            <input type="submit" class="btn btn-success" value="{{isset($event) ? 'Update' : 'Add'}}">
        </div>
    </form>
@endsection
