const {
    default: axios
} = require("axios");
const {
    event
} = require("jquery");

Vue.component('channel-uploads', {
    props: {
        channel: {
            type: Object,
            required: true,
            /**
             * 
             *  default is an empty object
             */
            default: () => ({})
        }

    },
    data: () => ({
        selected: false,
        /**
         * we notice in console.log of upload()
         * that a single video can be uploaded at a one time
         * so to store multiple video which means (2,3,4) more than >1 than
         * we have to convert it into array ..so one video is uploaded the automatically srat uploading
         * to specific channel>. and to loop over the videos 
         * before makeing videos array we wher simply storing video in constant
         * variable and the start uploading it to channel like this code
         *  upload(){
         *    console.log(this.$refs)
         *    this.selected = true
         *    const videos = this.$refs.videos.files
         *    console.log(videos)
         *    }
         */
        videos: [],
        progress: {}, //making object and initilizing it in map of Upload() for each video to show progress in forntend
        uploads: [], //for currently uploaded videos 
        intervals: {}

    }),
    methods: {
        upload() {
            this.selected = true
            /**
             * it take in any variable, itariable or thing and convert into array
             * and itariable basically anything that has a list or table in javascript
             * and an entites that can be look over 
             */
            this.videos = Array.from(this.$refs.videos.files)
            // console.log(videos) 


            /**
             * since videos is an array we can map over it. so foreach of the video
             * we are making axios.post (AJAX Request) request to server and send that
             * video to the server get the Response or a result. and then with the
             * uploader constant we are going to see that all the videos are uploaded
             * and then switch from uploading to progress showing of the videos
             * so here this dot videos dot map is taking each video 
             * and its going to create a new form. Const form  for it
             * and the map expects to return something and its going to replace its 
             * position into new array
             */
            const uploaders = this.videos.map(video => {
                const form = new FormData()


                /**
                 * initilizing here for each video and update it in 
                 * axio post request ..when ever an post request is make it going to be updated
                 */
                this.progress[video.name] = 0
                /**
                 * and then we are going to say form append
                 * and we are going to append key called video this is going
                 * to be the video.. it is very important you send the video into form
                 * and then we are going to say form dot append the title 
                 * and it will be going to the video video name or title
                 * when we check in the console before each video has a name or size 
                 * or other information regarding to that video all the orignal information of it
                 * 
                 */
                form.append('video', video)
                form.append('title', video.name)

                /**
                 * here making post request for each video in a form and passing the form to the axios post(AJAX request)
                 * channel id is received from channel Prop define in upload.blade.php
                 */
                return axios.post(`/channels/${this.channel.id}/videos`, form, {
                    /**
                     * event is used from jquery which is builtin function
                     * or event in jquery that just show the event Information and onUploadProgress is Vue Builtin
                     */
                    onUploadProgress: (event) => {
                        /**
                         * this event object can be seen in console.. all the information
                         * attributes used in this onUpladProgress all of its information
                         */
                        // console.log(event)
                        this.progress[video.name] = Math.ceil((event.loaded / event.total) * 100)

                        /**
                         * this is to force the update.. Vue Builtin Function
                         */
                        this.$forceUpdate()

                    }
                    /**
                     * now we are going to use .then to every time post is send ..in response it
                     * update the upload progress in front end as we see we are returning a video in videoController
                     * when video is Created 
                     */
                }).then(( {data})=>{
                    // console.log(data)
                    /**
                     * this upload define in data property ..
                     * and we are going to say this.uploads is equal to all of the uploads existing at the moment
                     */
                    this.uploads = [
                        ...this.uploads,
                        /**
                         * then we will add data to the new Upload. So one is uploaded it will push it into array 
                         */
                        data
                    ]

                })
            })
            /**
             * we will use axios.all to see all uploads are done 
             */
            axios.all(uploaders).then( () =>{
                this.videos = this.uploads
                this.videos.forEach(video /**this is a key for videos  */ =>{

            /**
             * interval .. which will make request after 3 seconds 
             * it makes a get request to the server to fetch the details of a video when it makes that get request
             * it gets the data from the server and it checks the percentage
             * if the percentage is 100 which means video is Uploaded and processed 
             * it will stop make request from that specific video    intervals[video.id]
             */
                this.intervals[video.id] = setInterval(()=>{
                    axios.get(`/videos/${video.id}`).then( ({data})=>{

                        /**
                         * putting check to check the current video on the serve 
                         * if the percentage from the serve of current video is 100 then clear interval for the current video id 
                         *  
                         */
                        if(data.percentage == 100){
                            clearInterval(this.intervals[video.id])
                        }
                    /**
                     * replace the current video with the new video we just got from server 
                     */
                    this.videos = this.videos.map(v /**key value for single instance */=>{
                         /**
                         * here we are mapping all of the videos to find the specific one 
                         * that we just got from the server and when we get it we are going to 
                         * replace it with the fresh copy recieved from the server 
                         * 
                         *  
                         */
                        if (v.id == data.id){
                            return data
                        }
                        /**
                         * and then for the others we are just simply maintaining them 
                         */
                        return v
                       

                    })

                    })
                },3000)

                })

            })


        }
    },
});
