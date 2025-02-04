<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class EventService.
 */
class EventService
{

    /**
     * @return Builder
     */
    public function build()
    {
        return Event::query();
    }

    /**
     * @return EventService
     */
    public static function query(){
        return new self();
    }


    public function getAll(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->build()->orderBy('created_at', 'desc')->paginate(5);
    }

    public function totalEvents(){
        return $this->build()->get()->count();
    }


    public function getEventById($id){
        return $this->query()->build()->where('id','=',$id)->first();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function create($request)
    {
        DB::transaction(function () use ($request, &$event){
            $event = new Event();
            $event->fill($request->validated());
            $event->save();
        });

        return $event;
    }
    /**
     * @param $request
     * @param $event
     * @return mixed
     */
    public function update($request, $event)
    {
        DB::transaction(function () use ($request, $event, &$Event) {
            $Event = $event->update($request->validated());
        });

        return $Event;
    }
}
