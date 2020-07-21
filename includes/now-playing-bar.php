<?php 
    $songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
    $resultArray = array();

    while($row = mysqli_fetch_array($songQuery)) {
        array_push($resultArray, $row['id']);
    }

    $jsonArray = json_encode($resultArray);

?>
<script>

    $(document).ready(function(){
        var newPlaylist = <?php echo $jsonArray; ?>;
        audioElement = new Audio();
        setTrack(newPlaylist[0], newPlaylist, false);
        updateVolumeProgressBar(audioElement.audio);

        $(document).keydown(function(e){
            if (e.keyCode == 32) {
                e.preventDefault();         
                 // add your code here.
                playbutton = !playbutton;
                if(playbutton){
                    playSong();
                } else {
                    pauseSong();
                }      
            }
        });

        $("#now-playing-bar-container").on("mousedown touchstart mousemove touchmove", function(e) {
            e.preventDefault();
        });
        // Controlling, dragging the progress bar
        $(".playback-bar .progress-bar").mousedown(function() {
            mouseDown = true;
        });

        $(".playback-bar .progress-bar").mousemove(function(e) {
            if(mouseDown) {
                // Set time of song, depending on position of mouse
                timeFromOffset(e, this);
            }
        });

        $(".playback-bar .progress-bar").mouseup(function(e) {
            timeFromOffset(e, this);
        });


        // for dragging controlling the volume
        $(".volume-bar .progress-bar").mousedown(function() {
            mouseDown = true;
        });

        $(".volume-bar .progress-bar").mousemove(function(e) {
            if(mouseDown) {
                var percentage = e.offsetX / $(this).width();
                if(percentage >= 0 && percentage <= 1 ){
                    audioElement.audio.volume = percentage;
                }
            }
        });

        $(".volume-bar .progress-bar").mouseup(function(e) {
            var percentage = e.offsetX / $(this).width();
            if(percentage >= 0 && percentage <= 1 ){
                 audioElement.audio.volume = percentage;
            }
        });

        $(document).mouseup(function() {
            mouseDown = false;
        });

       
    }); // end of document.ready

    
    function timeFromOffset(mouse, progressBar) {
        var percentage = mouse.offsetX / $(progressBar).width() * 100;
        var seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    }

    function prevSong() {
        if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
            audioElement.setTime(0);
        }else {
            currentIndex--;
            setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
            // playSong();
        }
    }

    function nextSong() {
        if(repeat == true) {
            audioElement.setTime(0);
            playSong();
            return;
        }

        if(currentIndex == currentPlaylist.length - 1){
            currentIndex = 0;
        } else {
            currentIndex++;
        } 

        var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true);
        
    }

    function setRepeat() {
        repeat = !repeat;
        var imageName = repeat ? "repeat-active.png" : "repeat.png"; 
        $(".control-button.repeat img").attr("src", "assets/images/icons/" + imageName);
    }

    // mute function
    function setMute() {
        audioElement.audio.muted = !audioElement.audio.muted;
        var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png"; 
        $(".control-button.volume img").attr("src", "assets/images/icons/" + imageName);
    }

    // Shuffle function
    function setShuffle() {
        shuffle = !shuffle;
        var imageName = shuffle ? "shuffle-active.png" : "shuffle.png"; 
        $(".control-button.shuffle img").attr("src", "assets/images/icons/" + imageName);

        if(shuffle === true) {
            //randomize playlist
            shuffleArray(shufflePlaylist);
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
        } else {
            //back to normal playlist
            currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
        }
    }

    function shuffleArray(array) {
             for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
    }


    function setTrack(trackId, newPlaylist, play){

        if(newPlaylist !== currentPlaylist) {
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        }

        if(shuffle) {
            currentIndex = shufflePlaylist.indexOf(trackId);
        } else {
            currentIndex = currentPlaylist.indexOf(trackId);
        }

        currentIndex = currentPlaylist.indexOf(trackId);
        pauseSong();
        
        $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data){

            var track = JSON.parse(data);
           
            $(".track-name span").text(track.title);

            $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data){
                var artist = JSON.parse(data);
              
                $(".track-info .artist-name span").text(artist.name);
                $(".track-info .artist-name span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
            });

            $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album}, function(data){
                var album = JSON.parse(data);
                $(".content .album-link img").attr("src", album.artworkPath);
                $(".content .album-link img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
                $(".track-info .track-name span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
            });

            audioElement.setTrack(track);
            // audioElement.play();
            // playSong();
            if(play){
           audioElement.play();
           playSong();
            }
        }); // AJAX call

        // audioElement.setTrack("assets/music/bensound-sunny.mp3");
        
    }
 
    function playSong() {
        playbutton = true;
        if(audioElement.audio.currentTime == 0) {
            $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id});
        };
        $(".control-button.play").hide();
        $(".control-button.pause").show();
        audioElement.play();
    }

    function pauseSong() {
        playbutton = false;
        $(".control-button.play").show();
        $(".control-button.pause").hide();
        audioElement.pause();
    }
</script>

<div id="now-playing-bar-container">
    <div id="now-playing-bar">
        <div id="now-playing-left">
            <div class="content">
                <span class="album-link">
                    <img role="link" tabIndex="0" src="" alt="dummy" class="album-artwork">
                </span>
                <div class="track-info">
                    <span class="track-name">
                        <span role="link" tabIndex="0"></span>
                    </span>
                    <span class="artist-name">
                        <span role="link" tabIndex="0"></span>
                    </span>                        
                </div>
            </div>
        </div>
        <div id="now-playing-center">
            <div class="content player-controls">
                <div class="buttons">
                    <button class="control-button shuffle" title="Shuffle button" onclick="setShuffle()"><img src="assets/images/icons/shuffle.png" alt="Shuffle"></button>

                    <button class="control-button previous" title="Previous button" onclick="prevSong()"><img src="assets/images/icons/previous.png" alt="Previous"></button>

                    <button class="control-button play" title="Play button" onclick="playSong()"><img src="assets/images/icons/play.png" alt="Play"></button>

                    <button class="control-button pause" title="Pause button" onclick="pauseSong()" style="display:none;"><img src="assets/images/icons/pause.png" alt="Pause"></button>

                    <button class="control-button next" title="Next button" onclick="nextSong()"><img src="assets/images/icons/next.png" alt="Next"></button>

                    <button class="control-button repeat" title="Repeat button" onclick="setRepeat()"><img src="assets/images/icons/repeat.png" alt="Repeat"></button>
                </div>

                <div class="playback-bar">
                    <span class="progress-time current">0.00</span>
                    <div class="progress-bar">
                        <div class="progress-bar-bg">
                            <div class="progress"></div>
                        </div>
                    </div>
                    <span class="progress-time remaining">0.00</span>
                </div>
            </div>
        </div>

        <div id="now-playing-right">
            <div class="volume-bar">
                <button class="control-button volume" title="Volume button" onclick="setMute()">
                    <img src="assets/images/icons/volume.png" alt="Volume">
                </button>
                <div class="progress-bar">
                        <div class="progress-bar-bg">
                            <div class="progress"></div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>