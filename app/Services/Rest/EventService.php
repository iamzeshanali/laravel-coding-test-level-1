<?php

namespace App\Services\Rest;

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
    public function build(): Builder
    {
        return Event::query();
    }

    /**
     * @return EventService
     */
    public static function query(): EventService
    {
        return new self();
    }


    /**
     * @return Builder|Collection
     */
    public function getAll(): Collection|Builder
    {
        return $this->build()->get();
    }

    /**
     * @param $request
     * @return Builder|Collection
     */
    public function getActiveEvents($request): Collection|Builder
    {
        $query =  $this->build()
                    ->whereBetween('created_at',[Carbon::parse($request->startAt)->toDateString(), Carbon::parse($request->endAt)->toDateString()]);
        return $query->get();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function create($request): mixed
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
    public function update($request, $event): mixed
    {
        DB::transaction(function () use ($request, $event, &$Event) {
            $Event = $event->updateOrCreate($request->validated());
        });

        return $Event;
    }

    /**
     * @param $request
     * @param $event
     * @return mixed
     */
    public function patch($request, $event): mixed
    {

        DB::transaction(function () use ($request, $event, &$Event) {
            $event->update($request->validated());
        });

        return $event;
    }
}
