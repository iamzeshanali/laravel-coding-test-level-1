@extends('app')
@section('title','Universities')
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
            <th>ID</th>
            <th>Nation</th>
            <th>ID Year</th>
            <th>Population</th>
            <th>Slug Nation</th>
        </tr>
        </thead>
        <tbody>
        @foreach($universities as $university)
            <tr>
                <td>
							<span class="custom-checkbox">
								<input type="checkbox" id="checkbox1" name="options[]" value="1">
								<label for="checkbox1"></label>
							</span>
                </td>
                <td>{{$university["ID Nation"]}}</td>
                <td>{{$university["Nation"]}}</td>
                <td>{{$university["ID Year"]}}</td>
                <td>{{$university["Population"]}}</td>
                <td>{{$university["Slug Nation"]}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
