<template>
       
                                    <button @click="toggleSubscription" class="btn btn-danger">
                                        <!-- it will check if the user is owner than it will show the empty string
                                            owner ? '' then if not owner than it will check if the user is subscribed
                                            then dispaly Unsubscribed   and Before Use of Numeral we wer just showing length
                                            of subscription  as this @{{subscriptions.length}}   and after use of numeral we just use 
                                            computed Count propert because it is counting lenth and returning in formate of 1k,1m,1b-->
                                        {{ owner ? '' : subscribed ? 'UnSubsribe' : 'Subscribe'}} {{count}} {{owner ? 'Subscribers':''}}
                                    </button>

</template>

<script>
import axios from 'axios'
import numeral from 'numeral'


export default {
    props: {
        /**
         * Props are not modify directly we have to use property Data for them
         */
        /**
         * we want to see the user is the owner of channel
         * for that we will use channel prop
         * remaining is in subscribed computed property and Owner computed property
         */
        channel: {
            type: Object,
            required: true,
            default: () => ({})

        },
        /**
         * subscription prop getting all the subscription in an array of current Channel 
         * bc we define hasMany relationship in Channel Model
         */
        subscriptionsList: {
            type: Array,
            required: true,
            default: () => []

        },

    },


    /**
     * we are going to use data property which we can modify 
     * if we use arrow funtion in data property then (This) cnnot be used 
     * we define the function here to get all the Array of subscription Prop
     * and update it as channel is subscribed or unsubscribed bascialy 
     * this property is used to update the subscription in Dom ..to make 
     * it reactive so when avery we update or delete subscription
     * we dont have to reload page to see the changes ..we are defing function here and returning it for Dom
     * is then using in the Tooglesubscribe to filter/update the dom by using .then() keyword/function 
     */
    data: function () {
        return {
            subscriptions: this.subscriptionsList
        }
    },



    /**
     * we want to check if the current user is subscribed
     * to the chanel or not .. now we will make a computed property
     * called subscribed ..this has a list of all subcribers..we can use this 
     * computed propery web page in show.blade.php
     */
    computed: {
        subscribed() {
            /**
             * here it will check if user is not authancated and channel.id != auth.id
             */
            if (!__auth() || this.channel.user_id == __auth().id) return false
            /**
             * find a record in the subscriptions array 
             * that matches the authacted user ..so we are going to say
             * find the subscription where the subscriptions.user_id=auth.user.id
             * we define the auth function in layout page in java script
             * we show the currents loged in user object
             * to return the bollean just add the !! in the start
             */
            return !!this.current_subscription
        },
        owner() {
            if (__auth() && this.channel.user_id == __auth().id) return true
            /**
             * just like else part if the above statement is true than return true and if it is not true than
             * return false
             */
            return false
        },

        current_user() {
            if (__auth()) {
                return __auth()
            }
        },

        current_subscription() {
            /**
             * find a record in the subscriptions array 
             * that matches the authacted user ..so we are going to say
             * find the subscription where the subscriptions.user_id=auth.user.id
             * we define the auth function in layout page in java script
             * we show the currents loged in user object
             * 
             */
            if (!__auth()) return null
            return this.subscriptions.find(subscriptions => subscriptions.user_id == __auth().id)


        },

        /**
         * Count computed property it will be used for counting numbers 
         * and the the numerial library imported Above all
         */
        count() {
            /**
             * returning numeral function on subscription total length 
             * as we can see it is a array 
             */
            return numeral(this.subscriptions.length).format('0a')
        }

    },
    methods: {
        toggleSubscription() {
            if (!__auth()) {
                return alert('please Login')
            }

            /**
             * a computed propert wich is checking it is owner or not
             */
            if (this.owner) {
                return alert('you can not subcribe your channel')
            }
            /**
             * we used Route modle Binding in the Subscription Controller
             * for store and destroy 
             * store(Channel $channel, Subscription $subscription){
             * here it will automaticaly get the required chaneel and subscription 
             * and perform operation 
             * 
             *   }
             */
            
            if (this.subscribed) {
                axios.delete(`/channels/${this.channel.id}/subscriptions/${this.current_subscription.id}`).then(() => {
                    this.subscriptions = this.subscriptions.filter(s => s.id != this.current_subscription.id)
                })
            } else {
                /**
                 * here Response is getting form Subscription controller thats why we use response in then() function 
                 */
                axios.post(`/channels/${this.channel.id}/subscriptions`).then(response => {
                    this.subscriptions = [
                        /**
                         * spred all the existing subceription array and add the newly response data
                         */
                        ...this.subscriptions,
                        response.data
                    ]
                })
            }


        }
    }
}

/**
 * we define props in Blade template in which 
 * and we are going to recieve probs here and they will be Recieved here
 * by Route Method binding we have a $channel object
 * and in channel model we define a subscriptions() Relation with Subscription Model
 * as we see in show.blade we are using $channel object  we define in ChannelController
 *  public function show(Channel $channel)
 *   {
 *      return view('channel.show',compact('channel'));
 * }
 * where we use  Route Method binding in Web.php
 * Route::resource('channels', ChannelController::class);
 */

/**
 * bind it on the <subscribe-button template where <subscribe-button></subscribe-button> 
 * bc it is nowworking as vue component 
 * we define Props for subscriptions 
 * as a type array its will be deal as array
 * by required true 
 * and make default function to empty array
 */

</script>