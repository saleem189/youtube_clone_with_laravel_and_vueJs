<template>
    <div>
    <i @click="vote('up')" class="far fa-thumbs-up">up: {{upvotes_count}}</i>
    <i @click="vote('down')" class="far fa-thumbs-up">down: {{downvotes_count}}</i>
    </div>
</template>


<script>
import numeral from 'numeral'
import axios from 'axios'
export default {
    /***
     * define propes here to get the Votes of Video 
     * in it it will get the default votes from database and
     * then it is assign as data property in votes to perform operations onit
     */
    props:{
        default_votes: {
            require: true,
            default:()=>[] //Array
        },

        // dealing entity as channel or Video  User_Owner
        entity_owner:{
            require: true,
            default: '' //as empty string
        },

        entity_id:{
            require: true,
            default: ''
        },
    },

    /***
     * Data Property for Default Votes 
     */
    data() {
        return {
            votes: this.default_votes
        }
    },

    /***
     * defining computed properties here to automatically perform
     * these operations 
     */
    computed:{
        /***
         * for Upvotes Thumbs Up
         */
        upvotes(){
            return this.votes.filter(v => v.type === 'up')
        },
        /***
         * for Downvotes Thumbs down
         */
        downvotes(){
            return this.votes.filter(v => v.type === 'down')
        },

        /***
         * show upvotes count in proper message like 1k ,1m by using numeral library
         */
        upvotes_count(){
            return numeral(this.upvotes.length).format('0a')
        },
        /***
         * show downvotes count in proper message like 1k ,1m by using numeral library
         */
        downvotes_count(){
            return numeral(this.downvotes.length).format('0a')

        },

        /***
         * checking here that user actually upvote and downvote 
         * by clicking on thumbs up and thumbs down icon
         */
        upvoted(){
        /**
         * checking if user is auntacated or not and finding current user id to check
         * if it has already voted or not  and Forcing it to boolean True or False
         */

        if(! __auth())  return false

        return !!this.upvotes.find(v =>v.user_id === __auth().id)

        },

        downvoted(){
        /**
         * checking if user is auntacated or not and finding current user id to check
         * if it has already voted or not 
         */

        if(! __auth())  return false

        return !!this.downvotes.find(v =>v.user_id === __auth().id)

        },

    },

    methods:{
        /**
         * for Upvote checking if it is owner or not
         */
        vote(type){
            if(!__auth()){
                return alert('please login to Vote')
            }

            if(__auth().id === this.entity_owner){
                return alert('You are owner so you cannot vote this Video')
            }

           

            if(type === 'up' && this.upvoted)  return
            if(type === 'down' && this.downvoted)  return

            axios.post(`/votes/${this.entity_id}/${type}`)
            .then( ({data})=>{
                /**
                 * for user already crated vote
                 * we updating existing record from the server
                 */
                if(this.upvoted || this.downvoted){
                    this.votes = this.votes.map(v => {
                        if(v.user_id === __auth().id){
                            return data
                        }
                        return v
                    })
                } else{
                    /**
                     * if it as never voted we are simpling add it to votes array
                     */
                    this.votes = [
                        ...this.votes,
                        data
                    ]
                }
            })
        },

        

    },
}
</script>
