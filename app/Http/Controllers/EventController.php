<?php

namespace App\Http\Controllers;

use App\Events\EventCreated;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Jobs\SendEmailJob;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
           'except'=>[
               'index', 'show'
           ]
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('event.events', [
                'events' => EventService::query()->getAll(),
                'totalEvents'=> EventService::query()->totalEvents()
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('event.add-update-events');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
            $event = EventService::query()->create($request);
            if(isset($event)){
                $this->dispatch(new SendEmailJob($event));
                return redirect()->route('events.index');
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('event.add-update-events', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('event.add-update-events', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event = EventService::query()->update($request, $event);
        if(isset($event)){
            return redirect()->route('events.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = EventService::query()->getEventById($id);
        if($event->delete()){
            return redirect()->route('events.index');
        }else{
            return redirect()->back();
        }
    }
}
