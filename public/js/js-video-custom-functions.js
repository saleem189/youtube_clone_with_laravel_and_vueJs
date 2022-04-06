// const { default: axios } = require("axios");


    var player = videojs('video_id')
    var viewLogged = false
    player.on('timeupdate', function () {
        var percentage = Math.ceil(player.currentTime()/player.duration()*100)
        if(percentage > 5 && !viewLogged){
            axios.put('/videos/' +window.CURRENT_VIDEO)
            viewLogged = true
        }
    }) 
    

