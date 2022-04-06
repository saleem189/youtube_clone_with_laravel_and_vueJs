<template>
<div>
 
    <div class="media my-3" v-for="reply in replies.data">
                    <a href="#" class="mr-3">
                        <img height="30" width="30" src="https://picsum.photos/id/42/200/200" alt=""
                            class="rounded-circle"></a>
                    <div class="media-body">
                        <h6 class="mt-0">{{reply.user.name}}</h6>
                        <small> {{reply.body}}</small>
                        <votes :default_votes="reply.votes" :entity_id="reply.id" :entity_owner="reply.user.id"></votes>

                    </div>
                </div>
                <div v-if="comment.repliesCount >0 && replies.next_page_url" class="text-center">
                <button @click="fetchReplies" class="btn btn-info bn-sm">
                    load Replies
                </button>
                </div>
</div>
</template> 
<script>
export default { 
    props: ['comment'],
    /**
     * this is a data function which will return a object
     */
    data(){
        return {
            replies: {
                data: [],
                next_page_url: `/comments/${this.comment.id}/replies`
            }
        }
    },
    methods:{
        fetchReplies(){
            /**
             * when user click on load more button it paginate to next page which we are
             * we are recieving through comments Data Property 
             * we will read below code like this .. if it has nextpage url thaen it is going to use it
             * if not then it will use /comments/${this.comment.id}/replies link 
             */
            axios.get(this.replies.next_page_url).then(({data}) => {
                this.replies = {
                    ...data,
                    /**
                     * here we are getting and showing new comments from the server
                     * and pushing to previous comments array by creating New Object for it
                     */
                    data: [
                        ...this.replies.data, //spread comments of data
                        ...data.data // and sperad comments from data of the server
                    ]
                }

            })

        },

        addReply(reply){
            this.replies={
                ...this.replies,
                data:[
                    reply,
                    ...this.replies.data
                ]
            }
        }
    }
    
}
</script>