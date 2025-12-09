<?php

if (!empty($playlistItems) && isset($playlistItems[0])) {
    $firstVideoId = $playlistItems[0]->snippet->resourceId->videoId;
    $firstVideoTitle = $playlistItems[0]->snippet->title;
    $description = $playlistItems[0]->snippet->description;
    $episode = 1;
} else {
    $firstVideoId = '';
}
?>
	<h2 class="title">Episodio <span id="episode"><?= $episode ?></span>: <span id="video-title"><?= $firstVideoTitle ?></span></h2>
		
	<div class="main-stage">
		<div id="yt-player"></div>
	</div>

	<p id="video-desc"><?= $description ?></p>

	<div class="thumbnails-track">
		<?php if (!empty($playlistItems)): ?>
			<?php foreach ($playlistItems as $index => $item): ?>
				<?php 
					$vidId = $item->snippet->resourceId->videoId;
					$title = $item->snippet->title;
					$description = $item->snippet->description;
					$episode = $index + 1;
					$thumbUrl = isset($item->snippet->thumbnails->medium) ? $item->snippet->thumbnails->medium->url : $item->snippet->thumbnails->default->url;

					$activeClass = ($index === 0) ? 'active' : '';
				?>
                    
				<div class="video-thumb <?= $activeClass ?>" 
					data-video-id="<?= $vidId ?>"
					data-video-title="<?= $title ?>"
					data-video-desc="<?= $description ?>"
					data-video-episode="<?= $episode ?>"
					onclick="changeVideo(this)">
						
					<img src="<?php echo $thumbUrl; ?>" alt="<?= $title ?>">
						
					<div class="thumb-overlay">
						<span class="play-icon">▶</span>
					</div>
					<div class="thumb-title"><?= $title ?></div>
				</div>

			<?php endforeach; ?>
		<?php else: ?>
			<p>No se encontraron videos.</p>
		<?php endif; ?>
	</div>

    <script>
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;
        var initialVideoId = "<?php echo $firstVideoId; ?>";

        function onYouTubeIframeAPIReady() {
            if(!initialVideoId) return;
			player = new YT.Player('yt-player', {
				height: '100%',
				width: '100%',
				videoId: initialVideoId,
				playerVars: {
					'rel': 0,
					'modestbranding': 1
				}
			});
		}

		function changeVideo(element) {
			let videoId = element.getAttribute('data-video-id');
			let videoTitle = element.getAttribute('data-video-title');
			let videoDesc = element.getAttribute('data-video-desc');
			let videoEpisode = element.getAttribute('data-video-episode');
			
			if (player && typeof player.loadVideoById === 'function') {
				player.loadVideoById(videoId);
			}

			let titleElement = document.getElementById('video-title');
			if (titleElement) {
				titleElement.textContent = videoTitle;
			}
			let descElement = document.getElementById('video-desc');
			if (descElement) {
				descElement.textContent = videoDesc;
			}
			let episodeElement = document.getElementById('episode');
			if (episodeElement) {
				episode.textContent = videoEpisode;
			}
			let thumbnails = document.querySelectorAll('.video-thumb');
			thumbnails.forEach(function(thumb) {
				thumb.classList.remove('active');
			});
			element.classList.add('active');

			document.querySelector('.main-stage').scrollIntoView({
				behavior: 'smooth', block: 'start' 
			});
		}
    </script>