@extends('app')
@section('content')
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>
                <span class="custom-checkbox">
                    <input type="checkbox" id="selectAll">
                    <label for="selectAll"></label>
                </span>
            </th>
            <th>Name</th>
            <th>Slug</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($events as $event)
            <tr>
                <td>
							<span class="custom-checkbox">
								<input type="checkbox" id="checkbox1" name="options[]" value="1">
								<label for="checkbox1"></label>
							</span>
                </td>
                <td>{{$event->name}}</td>
                <td>{{$event->slug}}</td>
                <td>{{$event->created_at}}</td>
                <td>{{$event->updated_at}}</td>
                <td class="d-flex">
                    <a href="{{route('events.show', $event->id)}}" class="edit"><i
                            class="material-icons" data-toggle="tooltip" title="View">&#xE8F4;</i></a>
                    <a href="{{route('events.edit', $event->id)}}" class="edit"><i
                            class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                    <a href="#deleteEventModal{{$event->id}}" class="delete" data-toggle="modal"><i
                            class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                    <!-- Delete Modal HTML -->
                    <div id="deleteEventModal{{$event->id}}" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Delete Event</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete these Records?</p>
                                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                    <form action="{{ route('events.destroy', $event->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="submit" class="btn btn-danger" value="Delete">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="clearfix">
        <div class="hint-text">Showing <b>{{count($events)}}</b> out of <b>{{$totalEvents}}</b> entries</div>
        <ul class="pagination">
            {!! $events->links() !!}
        </ul>
    </div>
@endsection
