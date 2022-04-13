<style>
/* Bootstrap 4 text input with search icon */

.has-search .form-control {
    padding-left: 2.375rem;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}
</style>

<template>
    <div class="form-group has-search" >
        <span class="fa fa-search form-control-feedback"></span>
        <input type="text" class="form-control" placeholder="Search"  v-model="keyword">


        <ul v-if="channels.length > 0">
           
            <li v-for="channel in channels" :key="channel.id"><a :href="'/channels/' + channel.id">{{ channel.name}}</a></li>
          
            
            
            
        </ul>
        
        
    </div>
</template>
<script>




export default {
    data() {
        return {
            keyword: null,
            channels: []
        };
    },
    watch: {
        keyword(after, before) {
            this.getResults();
        }
    },
    methods: {
        getResults() {
            axios.get('/search', { params: { keyword: this.keyword } })
                .then(res => this.channels = res.data)
                .catch(error => {});
        }
    }
}
</script>