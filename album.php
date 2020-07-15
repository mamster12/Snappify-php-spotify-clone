<?php include("includes/header.php");

    if(isset($_GET['id'])){
        $albumId = $_GET['id'];
    } else {
        header("Location: index.php");
    }

    $album = new Album($con, $albumId);
    $artist = $album->getArtist();

?>

<div class="entity-info">
    <div class="left-section">
        <img src="<?php echo $album->getAlbumArtwork(); ?>" alt="album">
    </div>
    <div class="right-section">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p>By <?php echo $artist->getName(); ?></p>
        <p><?php echo $album->getNumberOfSongs(); ?> songs</p>
    </div>
</div>

<div class="tracklist-container">
    <ul class='track-list'>
        
        <?php
        $songIdArray = $album->getSongIds();

        $i = 1;
        foreach($songIdArray as $songId) {
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
                    <img class='options-button' src='assets/images/icons/more.png' alt='more options'>
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
       
    </ul>
</div>

<?php include("includes/footer.php");?>