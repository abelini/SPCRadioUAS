<audio id="audio" preload="none" tabindex="0">
<?php foreach($playlist->Items as $song) {	?>
	<source src="<?= $http->buildURL('/Audio/'.$song->Id.'/stream.mp3', ['static' => 'true', 'api_key' => $api_key], $http->getConfig())?>" data-track-number="<?= $index++ ?>" type="audio/mpeg"/>
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
			<div class="audio-time">
				<span class="current-time">00:00</span> / <span class="duration">00:00</span>
			</div>
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

<div class="play-list">
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