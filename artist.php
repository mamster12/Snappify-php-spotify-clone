<?php 
include("includes/includedFiles.php");

    if(isset($_GET['id'])){
        $artistId = $_GET['id'];
    } else {
        header("Location: index.php");
    }

    $artist = new Artist($con, $artistId);

?>
<script>
    $("button").on("mousedown touchstart mousemove touchmove", function(e) {
            e.preventDefault();
        });

</script>

<div class="entity-info border-bottom">
    <div class="center-section">
        <div class="artist-info">
            <h1 class="artist-name"><?php echo $artist->getName(); ?></h1>
            <div class="header-buttons">
                <button class="button green" onclick="playFirstSong()">PLAY</button>
            </div>
        </div>
    </div>
</div>

<div class="tracklist-container border-bottom">
    <h2 class="artist-page-headings">SONGS</h2>
    <ul class='track-list'>
        
        <?php
        $songIdArray = $artist->getSongIds();

        $i = 1;
        foreach($songIdArray as $songId) {
            if($i > 5) {
                break;
            }
           $albumSong = new Song($con, $songId);
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

<div class="grid-view-container">
    <h2 class="artist-page-headings">ALBUMS</h2>
        <?php 
            $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'");

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