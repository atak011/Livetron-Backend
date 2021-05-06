<?php


namespace App\Services;


use App\Models\Event;
use App\Models\EventRef;

class EventService
{


    static function create($data){
        return Event::create($data);
    }

    static function createRefLink($data){
        return EventRef::create($data);
    }

    static function getBySlug($slug){
        return Event::with('products')->where('slug',$slug)->first();
    }

    static function serializeProviderStatus($request){

        $list = [];
        foreach ($request['monitors'] as $monitor){
            if ($monitor['friendly_name'] == 'Twillio'){
                if ($monitor['status'] == 2){
                    array_push($list,['name' => 'Twillio','status'=>'UP']);
                }else{
                    array_push($list,['name' => 'Twillio','status'=>'DOWN']);
                }
            }

            if ($monitor['friendly_name'] == 'Zoom'){
                if ($monitor['status'] == 2){
                    array_push($list,['name' => 'Zoom','status'=>'UP']);
                }else{
                    array_push($list,['name' => 'Zoom','status'=>'DOWN']);
                }
            }
        }
        return $list;
    }

    static function increaseParticipantWithRef($eventId,$refCode){

        $event = Event::find($eventId);
        $event->participation = $event->participation+1;
        $event->save();
        if ($refCode){
            $ref = EventRef::where('code',$refCode)->first();
            $ref->participation =  $ref->participation+1;
            $ref->save();
        }
        return $event;
    }
}
