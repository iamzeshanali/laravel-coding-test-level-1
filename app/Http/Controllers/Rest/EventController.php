<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\GetActiveEventRequest;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Jobs\SendEmailJob;
use App\Models\Event;
use App\Services\Rest\EventService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        return response(EventResource::collection(EventService::query()->getAll()));
    }

    /**
     * @param GetActiveEventRequest $request
     * @return Response|Application|ResponseFactory
     */
    public function activeEvents(GetActiveEventRequest $request): Response|Application|ResponseFactory
    {
        return response(EventResource::collection(EventService::query()->getActiveEvents($request)));
    }

    /**
     * @param StoreEventRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function store(StoreEventRequest $request): Response|Application|ResponseFactory
    {
        $event = EventService::query()->create($request);
        Redis::set('event_' .$event->id, $event);
        $this->dispatch(new SendEmailJob($event));
        return response(new EventResource($event));
    }

    /**
     * @param Event $event
     * @return Application|ResponseFactory|Response
     */
    public function show(Event $event): Response|Application|ResponseFactory
    {
        $cachedEvent = Redis::get('event_' . $event->id);
        if(isset($cachedEvent)) {
            $event = json_decode($cachedEvent, FALSE);
        }
        return response(new EventResource($event));
    }

    /**
     * @param UpdateEventRequest $request
     * @param Event $event
     * @return Application|ResponseFactory|Response
     */
    public function update(UpdateEventRequest $request, Event $event): Response|Application|ResponseFactory
    {
        return response(new EventResource(EventService::query()->update($request, $event)));
    }

    /**
     * @param UpdateEventRequest $request
     * @param Event $event
     * @return Application|ResponseFactory|Response
     */
    public function patch(UpdateEventRequest $request, Event $event): Response|Application|ResponseFactory
    {
        return response(new EventResource(EventService::query()->patch($request, $event)));

    }

    /**
     * @param Event $event
     * @return JsonResponse
     */
    public function destroy(Event $event): JsonResponse
    {
        try {
            if (!$event->delete()) {
                throw new \Exception('Error', 500);
            }
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], $e->getCode(), false);
        }

        Redis::del('event_' . $event->id);

        return response()->json(['ok' => true, 'message' => 'Deleted Successfully']);
    }
}
