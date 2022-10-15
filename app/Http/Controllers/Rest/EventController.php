<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\GetActiveEventRequest;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\Rest\EventService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(EventResource::collection(EventService::query()->getAll()));
    }

    public function activeEvents(GetActiveEventRequest $request){
        return response(EventResource::collection(EventService::query()->getActiveEvents($request)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEventRequest $request
     * @return Response
     */
    public function store(StoreEventRequest $request)
    {
        return response(new EventResource(EventService::query()->create($request)));
    }

    /**
     * @param Event $event
     * @return Application|ResponseFactory|Response
     */
    public function show(Event $event)
    {
        return response(new EventResource($event));
    }

    /**
     * @param UpdateEventRequest $request
     * @param Event $event
     * @return Application|ResponseFactory|Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        return response(new EventResource(EventService::query()->update($request, $event)));
    }

    /**
     * @param UpdateEventRequest $request
     * @param Event $event
     * @return Application|ResponseFactory|Response
     */
    public function partiallyUpdate(UpdateEventRequest $request, Event $event){
        return response(new EventResource(EventService::query()->partiallyUpdate($request, $event)));

    }

    /**
     * @param Event $event
     * @return JsonResponse
     */
    public function destroy(Event $event)
    {
        try {
            if (!$event->delete()) {
                throw new \Exception('Error', 500);
            }
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], $e->getCode(), false);
        }


        return response()->json(['ok' => true, 'message' => 'Deleted Successfully']);
    }
}
