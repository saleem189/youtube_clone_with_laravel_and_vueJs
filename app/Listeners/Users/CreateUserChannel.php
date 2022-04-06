<?php

namespace App\Listeners\Users;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class CreateUserChannel
{
    /**
     * Before Event Listerner working is Defined in Channel Model.
     * this Listner is attached with Register Event ..when ever a new User
     * is registerd this code is going to run which is Written in Handle() 
     */



    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        /**
         * $event which is passed from the Newely created user Event from Laravel Auth
         * here new registerd event is triggered  every time new user register
         * public function register(Request $request)
         * {
         *   $this->validator($request->all())->validate();
         **   event(new Registered($user = $this->create($request->all())));
         *   $this->guard()->login($user);
         *   if ($response = $this->registered($request, $user)) {
         *   return $response;
         * }
         *  return $request->wantsJson()
         **             ? new JsonResponse([], 201)
         *              : redirect($this->redirectPath());
         * }
         * 
         * so here we assising newly created user by $event Object
         */
       
        
        $event->user->channel()->create([
            /**
             * here i used $event->user->name."channel" for
             * concatination     .(operator is used for concatination)
             */
            'name' =>$event->user->name.' '."channel"
        ]);
    }
}
