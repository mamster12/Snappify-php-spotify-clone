<?php
include("includes/includedFiles.php");
?>

<div class="playlists-container">
    <div class="grid-view-container">
        <h2 class="yourmusic-page-headings">PLAYLISTS</h2>
        <div class="button-items">
            <button class="button green" onclick="createPlaylist()">
                NEW PLAYLIST
            </button>
        </div>

        <?php 
            $username = $userLoggedIn->getUsername();
            $playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");

            if(mysqli_num_rows($playlistsQuery) == 0) {
                echo "<span class='no-results'>You don't have any playlist yet.</span>";
            }

            while($row = mysqli_fetch_array($playlistsQuery)) {
                $playlist = new Playlist($con, $row);

                echo "<div class='grid-view-item' role='link' tabIndex='0' onclick='openPage(\"playlist.php?id=". $playlist->getId() ."\")'>
                    <div class='playlist-image'>
                        <img src='assets/images/icons/playlist.png'>
                    </div>
                    <div class='grid-view-info'>". $playlist->getName() .
                    "</div>
                </div>";
            }
        ?>


    </div>
</div>