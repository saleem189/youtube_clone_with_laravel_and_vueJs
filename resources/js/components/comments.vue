<template>
    <div class="card mt-5 p-5">
        <div v-if="auth" class="form-inline my-4 w-full">
            <input v-model="newComment" type="text" class="form-control form-control-sm w-80">
            <button @click="addComment" class="btn btn-sm btn-primary">
                <small> Add Comment </small>
            </button>
        </div>
       <comment v-for="comment in comments.data" :key="comment.id" :comment="comment" :video="video"></comment>
        <button @click="fetchComments" v-if="comments.next_page_url" class="btn btn-success">
            load More
        </button>
        <span v-else>No more Comments to show</span>
    </div>
</template>

<script>
    import axios from 'axios'
    
    import votes from './votes.vue'
import Comment from './comment.vue'
    export default {
  components: { votes, Comment },
        props: ['video'],
       
        data: () => ({
            comments: {
                data: []
            },
            newComment:''
        }),
        /**
         * when this Component is Mounted 
         */
        mounted() {
            this.fetchComments()
        },

        /**
         * Computed property just to check a user is loged in or not
         */
        computed:{
            auth(){
                return __auth()
            }
            
        },

        methods: {
            fetchComments() {
                /**
                 * when user click on load more button it paginate to next page which we are
                 * we are recieving through comments Data Property 
                 * we will read below code like this .. if it has nextpage url thaen it is going to use it
                 * if not then it will use /videos/${this.video.id}/comments link 
                 */
                const url = this.comments.next_page_url ? this.comments.next_page_url :
                    `/videos/${this.video.id}/comments`
                axios.get(url).then(({
                    data
                }) => {
                    // this.comments = data
                    this.comments = {
                        ...data,
                        /**
                         * here we are getting and showing new comments from the server
                         * and pushing to previous comments array by creating New Object for it
                         */
                        data: [
                            ...this.comments.data, //spread comments of data
                            ...data.data // and sperad comments from data of the server
                        ]
                    }

                })
            },

            addComment(){
                if(! this.newComment) return

                axios.post(`/comments/${this.video.id}`,{
                    body: this.newComment
                }).then(({data})=>{
                    
                     this.comments = {
                       /**
                        * spread all the Comments 
                        */
                         ...this.comments,
                         /**
                          * and new Data is going to be
                          */
                         data:[
                             data,
                             ...this.comments.data
                             
                         ]
                     }
                    
                })
            }

        }

    }

</script>
