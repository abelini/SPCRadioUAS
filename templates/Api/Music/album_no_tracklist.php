<h4 class="album"><?= $albumInfo->Items[0]->Name ?></h4>
<h5 class="artist">&raquo; <?= $albumInfo->Items[0]->AlbumArtist ?></h5>

<audio id="audio" preload="none" tabindex="0">
<?php foreach($playlist->Items as $song) {	?>
	<source src="<?= $http->buildURL('/Audio/'.$song->Id.'/stream.mp3', ['api_key' => $api_key], $http->getConfig())?>" data-track-number="<?= $index++ ?>" />
<?php } ?>
</audio>
	
<img src="<?= $cover ?>" style="padding:12px;max-width:90%;width:480px;display:block;margin:auto;">

<div class="player">
	<div class="large-toggle-btn">
		<i class="large-play-btn"><span class="screen-reader-text">Large toggle button</span></i>
	</div>
	<div class="info-box">
		<div class="track-info-box">
			<div class="track-title-text"></div>
		</div>
		<div class="progress-box">
			<div class="progress-cell">
				<div class="progress">
					<div class="progress-buffer"></div>
					<div class="progress-indicator"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="controls-box">
		<i class="previous-track-btn disabled"><span class="screen-reader-text">Previous track button</span></i>
		<i class="next-track-btn"><span class="screen-reader-text">Next track button</span></i>
	</div>
</div>

<?php $index = 1; ?>

<div class="play-list" style="display:none;">
<?php foreach($playlist->Items as $item) {	?>
	<div class="play-list-row" data-track-row="<?= $index ?>">
		<div class="small-toggle-btn">
			<i class="small-play-btn"><span class="screen-reader-text">Small toggle button</span></i>
		</div>
		<div class="track-number"><?= $index ?></div>
		<div class="track-title">
			<a class="playlist-track" href="#" data-play-track="<?= $index++ ?>"><?= $item->Name?></a>
		</div>
	</div>
<?php } ?>
</div>

<style>
	h4,h5{text-transform:uppercase;font-family:Montserrat;font-weight:500;padding:0 12px;margin:0 0 8px;}
	.album{font-size:18px;color:#051a2dBF !important}
	.artist{font-size:16px;color:#999;}
</style>