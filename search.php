<?php 
    include("includes/includedFiles.php");
    if(isset($_GET['term'])) {
        $term = urldecode($_GET['term']);
    } else {
        $term = "";
    }
?>

<div class="search-container">
    <h4>Search for an artist, album or song</h4>
    <input type="text" class="search-input" value="<?php echo $term; ?>" placeholder="start typing..." onfocus="var value = this.value; this.value = null; this.value = value;">
</div>

<script>
    $(".search-input").focus();
    $(function(){
        
        $(".search-input").keyup(function(){
            clearTimeout(timer);
            timer = setTimeout(function() {
                var val = $(".search-input").val();
                openPage("search.php?term=" + val);
            }, 2000);
        });
    });
</script>

<?php if($term == "") exit(); ?>

<div class="tracklist-container border-bottom">
    <h2 class="artist-page-headings">SONGS</h2>
    <ul class='track-list'>
        
        <?php

        $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");


        if(mysqli_num_rows($songsQuery) == 0) {
            echo "<span class='no-results'>No songs found matching " . "'" . $term . "'" . "</span>";
        }

        $songIdArray = array();

        $i = 1;
        while($row = mysqli_fetch_array($songsQuery)) {
            if($i > 15) {
                break;
            }
            array_push($songIdArray, $row['id']);

           $albumSong = new Song($con, $row['id']);
           $albumArtist = $albumSong->getArtist();

           echo "<li class='tracklist-row'>
                <div class='track-count'>
                    <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"".$albumSong->getId()."\",tempPlaylist, true)'>
                    <span class='track-number'>$i</span>
                </div>
                <div class='track-info'>
                    <span class='track-name'>".$albumSong->getTitle()."</span>
                    <span class='artist-name'>".$albumArtist->getName()."</span>
                </div>

                <div class='track-options'>
                    <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                    <img class='options-button' src='assets/images/icons/more.png' alt='more options' onclick='showOptionsMenu(this)'>
                </div>

                <div class='track-duration'>
                    <span class='duration'>".$albumSong->getDuration()."</span>
                </div>
           </li>";
           $i++;         
        }
        ?>

        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>
       
    </ul><br>
</div>

<div class="artists-container border-bottom">
    <h2 class="artist-page-headings">ARTISTS</h2>

    <?php 
        $artistsQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");

        if(mysqli_num_rows($artistsQuery) == 0) {
            echo "<span class='no-results'>No artists found matching " . "'" . $term . "'" . "</span>";
        }
      
        while($row = mysqli_fetch_array($artistsQuery)) {
            $artistFound = new Artist($con, $row['id']);

            echo "<div class='search-result-row'>
                    <div class='artist-name'>
                        <span role='link' tabIndex='0' onclick='openPage(\"artist.php?id=". $artistFound->getId() ."\")'>
                            "
                            . $artistFound->getName() .
                            "
                        </span>
                    </div>
                </div>";
        }
    ?>
</div>

<div class="grid-view-container">
    <h2 class="artist-page-headings">ALBUMS</h2>
        <?php 
            $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10");

            if(mysqli_num_rows($albumQuery) == 0) {
                echo "<span class='no-results'>No albums found matching " . "'" . $term . "'" . "</span>";
            }

            while($row = mysqli_fetch_array($albumQuery)) {
                echo "<div class='grid-view-item'>
                    <span role='link' tabindex='0' onclick='openPage(\"album.php?id=". $row['id']."\")'>
                        <img src='". $row['artworkPath'] ."'>
                        <div class='grid-view-info'>". $row['title'] .
                        "</div>
                    </span>
                </div>";
            }
        ?>
    </div>
    <nav class="options-menu">
        <input type="hidden" class="songId">
        <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
    </nav>
   