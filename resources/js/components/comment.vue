<template>

    <div class="media my-3 ">

        <img src="https://picsum.photos/id.42/200/200" width="30" height="30" class="rounded-circle mr-3" alt="">
        <div class="media-body">
            <h6 class="mt-0">{{comment.user.name}}</h6>
            <small> {{comment.body}}</small>

            <div class="d-flex">
                <!-- Passing comment from the loop of comments.data  -->
                <votes :default_votes="comment.votes" :entity_id="comment.id" :entity_owner="comment.user.id"></votes>
                <button @click="addingReply=!addingReply" class="btn btn-sm ml-2" :class="{'btn-default': !addingReply , 'btn-danger':addingReply}">{{addingReply ? 'Cancle':'Add Reply'}}</button>
            </div>
            <div v-if="addingReply" class="form-inline my-4 w-full">
                <input v-model="body" type="text" class="form-control form-control-sm w-80">
                <button @click="addReply" class="btn btn-sm btn-primary">
                    <small> Add Reply </small>
                </button>
            </div>
            <replies ref="replies" :comment="comment"></replies>

        </div>
    </div>
</template>

<script>
import axios from 'axios'
    import Replies from './replies.vue'
    export default {
        component: {
            Replies
        },
        props: {
            comment: {
                required: true,
                default: () => ({})
            },
            video:{
                 required: true,
                default: () => ({})
            }
        },
        data(){
            return{
                body: '',
                addingReply:false
            }
        },
        methods:{
            addReply(){
                if(! this.body) return
                axios.post(`/comments/${this.video.id}`,{
                    comment_id:this.comment.id,
                    body: this.body
                }).then(({data})=>{
                    this.body = ''
                    this.addingReply=false
                    this.$refs.replies.addReply(data)
                })
            }
        }
    }

</script>
