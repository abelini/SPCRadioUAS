<!doctype>
<html>
	<body>
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1" />
		</head>
		
		<div class="container">
			<?= $this->fetch('content');?>
		</div>
		
		<script>
			let audioPlayer = function() {
				"use strict";
				let _currentTrack = null;
				let _elements = {
					audio: document.getElementById("audio"),
					playerButtons: {
						largeToggleBtn: document.querySelector(".large-toggle-btn"),
						nextTrackBtn: document.querySelector(".next-track-btn"),
						previousTrackBtn: document.querySelector(".previous-track-btn"),
						smallToggleBtn: document.getElementsByClassName("small-toggle-btn")
					},
					progressBar: document.querySelector(".progress-box"),
					playListRows: document.getElementsByClassName("play-list-row"),
					trackInfoBox: document.querySelector(".track-info-box")
				};
				 console.log(_elements.audio);
				let _playAHead = false;
				let _progressCounter = 0;
				let _progressBarIndicator = _elements.progressBar.children[0].children[0].children[1];
				let _trackLoaded = false;
				let _bufferProgress = function(audio) {
					let bufferedTime = (audio.buffered.end(0) * 100) / audio.duration;
					let progressBuffer = _elements.progressBar.children[0].children[0].children[0];
					progressBuffer.style.width = bufferedTime + "%";
				};
				let _getXY = function(e) {
					let containerX = _elements.progressBar.offsetLeft;
					let containerY = _elements.progressBar.offsetTop;
					let coords = {x: null, y: null};
					let isTouchSuopported = "ontouchstart" in window;
					if (isTouchSuopported) {
						return {x:(e.clientX - containerX), y:(e.clientY - containerY)};
					} else if (e.offsetX || e.offsetX === 0) {
						return {x:e.offsetX, y:e.offsetY};
					} else if (e.layerX || e.layerX === 0) {
						return {x:e.layerX, y:e.layerY};
					}
				};
				let _handleProgressIndicatorClick = function(e) {
					let progressBar = document.querySelector(".progress-box");
					let xCoords = _getXY(e).x;
					let result = (xCoords - progressBar.offsetLeft) / progressBar.children[0].offsetWidth;
					return result;
				};
				let initPlayer = function() {
					if (_currentTrack === 1 || _currentTrack === null) {
						_elements.playerButtons.previousTrackBtn.disabled = true;
					}
				    for (let i = 0; i < _elements.playListRows.length; i++) {
						let smallToggleBtn = _elements.playerButtons.smallToggleBtn[i];
						let playListLink = _elements.playListRows[i].children[2].children[0];
						playListLink.addEventListener("click", function(e) {
							e.preventDefault();
							let selectedTrack = parseInt(this.parentNode.parentNode.getAttribute("data-track-row"));  console.log(selectedTrack);
							if (selectedTrack !== _currentTrack) {
								_resetPlayStatus(); _currentTrack = null; _trackLoaded = false;
							}
							if (_trackLoaded === false) {
								_currentTrack = parseInt(selectedTrack); _setTrack();
							} else {
								_playBack(this);
							}
						}, false);
						smallToggleBtn.addEventListener("click", function(e) {
							e.preventDefault();
							let selectedTrack = parseInt(this.parentNode.getAttribute("data-track-row"));
							if (selectedTrack !== _currentTrack) {
								_resetPlayStatus(); _currentTrack = null; _trackLoaded = false;
							}
							if (_trackLoaded === false) {
								_currentTrack = parseInt(selectedTrack);
								_setTrack();
							} else {
								_playBack(this);
							}
						}, false);
					}
					_elements.audio.addEventListener("timeupdate", _trackTimeChanged, false);
					_elements.audio.addEventListener("ended", function(e) {
						_trackHasEnded();
					}, false);
					_elements.audio.addEventListener("error", function(e) {
						switch (e.target.error.code) {
							case e.target.error.MEDIA_ERR_ABORTED:
								console.log('You aborted the video playback.');	break;
							case e.target.error.MEDIA_ERR_NETWORK:
								console.log('A network error caused the audio download to fail.'); break;
							case e.target.error.MEDIA_ERR_DECODE:
								console.log('The audio playback was aborted due to a corruption problem or because the video used features your browser did not support.'); break;
							case e.target.error.MEDIA_ERR_SRC_NOT_SUPPORTED:
								console.log('The video audio not be loaded, either because the server or network failed or because the format is not supported.'); break;
							default: console.log('An unknown error occurred.');
						}
						_trackLoaded = false; _resetPlayStatus();
					}, false);
					_elements.playerButtons.largeToggleBtn.addEventListener("click", function(e) {
						if (_trackLoaded === false) {
							_currentTrack = parseInt(1); _setTrack();
						} else {
							_playBack();
						}
					}, false);
					_elements.playerButtons.nextTrackBtn.addEventListener("click", function(e) {
						if (this.disabled !== true) {
							_currentTrack++; _trackLoaded = false; _resetPlayStatus(); _setTrack();
						}
					}, false);
					_elements.playerButtons.previousTrackBtn.addEventListener("click", function(e) {
						if (this.disabled !== true) {
							_currentTrack--; _trackLoaded = false; _resetPlayStatus(); _setTrack();
						}
					}, false);
					_progressBarIndicator.addEventListener("mousedown", _mouseDown, false);
					window.addEventListener("mouseup", _mouseUp, false);
				};
				let _mouseDown = function(e) {
					window.addEventListener("mousemove", _moveProgressIndicator, true);
					audio.removeEventListener("timeupdate", _trackTimeChanged, false);
					_playAHead = true;
				};
				let _mouseUp = function(e) {
					if(_playAHead === true) {
						let duration = parseFloat(audio.duration);
						let progressIndicatorClick = parseFloat(_handleProgressIndicatorClick(e));
						window.removeEventListener("mousemove", _moveProgressIndicator, true);
						console.log('progressIndicatorClick: ', progressIndicatorClick);
						audio.currentTime = duration * progressIndicatorClick;
						audio.addEventListener("timeupdate", _trackTimeChanged, false);
						_playAHead = false;
					}
				};
				let _moveProgressIndicator = function(e) {
					let newPosition = 0;
					let progressBarOffsetLeft = _elements.progressBar.offsetLeft;
					let progressBarWidth = 0;
					let progressBarIndicator = _elements.progressBar.children[0].children[0].children[1];
					let progressBarIndicatorWidth = _progressBarIndicator.offsetWidth;
					let xCoords = _getXY(e).x;
					progressBarWidth = _elements.progressBar.children[0].offsetWidth - progressBarIndicatorWidth;
					newPosition = xCoords - progressBarOffsetLeft;
					if ((newPosition >= 1) && (newPosition <= progressBarWidth)) {
						progressBarIndicator.style.left = newPosition + ".px";
					}
					if (newPosition < 0) {
						progressBarIndicator.style.left = "0";
					}
					if (newPosition > progressBarWidth) {
						progressBarIndicator.style.left = progressBarWidth + "px";
					}
				};
				let _playBack = function() {
					if(_elements.audio.paused) {
						_elements.audio.play(); _updatePlayStatus(true); document.title = "\u25B6 " + document.title;
					} else {
						_elements.audio.pause(); _updatePlayStatus(false); document.title = document.title.substr(2);
					}
				};
				let _setTrack = function() {
					let songURL = _elements.audio.children[_currentTrack - 1].src;
					_elements.audio.setAttribute("src", songURL);
					_elements.audio.load();
					_trackLoaded = true;
					_setTrackTitle(_currentTrack, _elements.playListRows);
					_setActiveItem(_currentTrack, _elements.playListRows);
					_elements.trackInfoBox.style.visibility = "visible";
					_playBack();
				};
				let _setActiveItem = function(currentTrack, playListRows) {
					for (let i = 0; i < playListRows.length; i++) {
						playListRows[i].children[2].className = "track-title";
					}
					playListRows[currentTrack - 1].children[2].className = "track-title active-track";
				};
				let _setTrackTitle = function(currentTrack, playListRows) {
					let trackTitleBox = document.querySelector(".player .info-box .track-info-box .track-title-text");
					let trackTitle = playListRows[currentTrack - 1].children[2].outerText;
					trackTitleBox.innerHTML = null;
					trackTitleBox.innerHTML = trackTitle;
					document.title = trackTitle;
				};
				let _trackHasEnded = function() {
					parseInt(_currentTrack);
					_currentTrack = (_currentTrack === _elements.playListRows.length) ? 1 : _currentTrack + 1;
					_trackLoaded = false;
					_resetPlayStatus();
					_setTrack();
				};
				let _trackTimeChanged = function() {
					let currentTimeBox = document.querySelector(".player .info-box .track-info-box .audio-time .current-time");
					let currentTime = audio.currentTime;
					let duration = audio.duration;
					let durationBox = document.querySelector(".player .info-box .track-info-box .audio-time .duration");
					let trackCurrentTime = _trackTime(currentTime);
					let trackDuration = _trackTime(duration);
					currentTimeBox.innerHTML = null;
					currentTimeBox.innerHTML = trackCurrentTime;
					durationBox.innerHTML = null;
					durationBox.innerHTML = trackDuration;
					_updateProgressIndicator(audio);
					_bufferProgress(audio);
				};
				let _trackTime = function(seconds) {
					let min = 0;
					let sec = Math.floor(seconds);
					let time = 0;
					min = Math.floor(sec / 60);
					min = min >= 10 ? min : '0' + min;
					sec = Math.floor(sec % 60);
					sec = sec >= 10 ? sec : '0' + sec;
					time = min + ':' + sec;
					return time;
				};
				let _updatePlayStatus = function(audioPlaying) {
					if (audioPlaying) {
						_elements.playerButtons.largeToggleBtn.children[0].className = "large-pause-btn";
						_elements.playerButtons.smallToggleBtn[_currentTrack - 1].children[0].className = "small-pause-btn";
					} else {
						_elements.playerButtons.largeToggleBtn.children[0].className = "large-play-btn";
						_elements.playerButtons.smallToggleBtn[_currentTrack - 1].children[0].className = "small-play-btn";
					}
					if(_currentTrack === 1) {
						_elements.playerButtons.previousTrackBtn.disabled = true;
						_elements.playerButtons.previousTrackBtn.className = "previous-track-btn disabled";
					} else if (_currentTrack > 1 && _currentTrack !== _elements.playListRows.length) {
						_elements.playerButtons.previousTrackBtn.disabled = false;
						_elements.playerButtons.previousTrackBtn.className = "previous-track-btn";
						_elements.playerButtons.nextTrackBtn.disabled = false;
						_elements.playerButtons.nextTrackBtn.className = "next-track-btn";
					} else if (_currentTrack === _elements.playListRows.length) {
						_elements.playerButtons.nextTrackBtn.disabled = true;
						_elements.playerButtons.nextTrackBtn.className = "next-track-btn disabled";
					}
				};
				let _updateProgressIndicator = function() {
					let currentTime = parseFloat(_elements.audio.currentTime);
					let duration = parseFloat(_elements.audio.duration);
					let indicatorLocation = 0;
					let progressBarWidth = parseFloat(_elements.progressBar.offsetWidth);
					let progressIndicatorWidth = parseFloat(_progressBarIndicator.offsetWidth);
					let progressBarIndicatorWidth = progressBarWidth - progressIndicatorWidth;
					indicatorLocation = progressBarIndicatorWidth * (currentTime / duration);
					_progressBarIndicator.style.left = indicatorLocation + "px";
				};
				let _resetPlayStatus = function() {
					let smallToggleBtn = _elements.playerButtons.smallToggleBtn;
					_elements.playerButtons.largeToggleBtn.children[0].className = "large-play-btn";
					for (let i = 0; i < smallToggleBtn.length; i++) {
						if (smallToggleBtn[i].children[0].className === "small-pause-btn") {
							smallToggleBtn[i].children[0].className = "small-play-btn";
						}
					}
				};
				return {initPlayer: initPlayer};
			};

			(function() {
				let player = new audioPlayer();
				player.initPlayer();
			})();
		</script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css">
		<style type="text/css">
			.screen-reader-text {
			  position: absolute;
			  top: -9999px;
			  left: -9999px;
			}
			.disabled {
			  color: #666;
			  cursor: default;
			}
			.show {
			  display: inline-block !important;
			}
			body {
			  margin: 10px 0 0 0; background-color:#<?= $bgColor ?>;
			}
			body .container {
			  font-family: arial, helvetica, sans-serif;
			  font-size: 1em;
			  margin: 0 auto; padding:8px;
			  /*width:600px;*/
			}
			body .container .player {
			  height: 60px;
			  margin: 0;
			  position: relative;
			  width:100%;
			  /* Small devices (tablets, 768px and up) */
			  /* Medium devices (desktops, 992px and up) */
			  /* Large devices (large desktops, 1200px and up) */
			  *zoom: 1;
			}
			@media (min-width: 768px) and (max-width: 991px) {
			  body .container .player {
			    width: 570px;
			  }
			}
			@media (min-width: 992px) and (max-width: 1100px) {
			  body .container .player {
			    width: 570px;
			  }
			}
			@media (min-width: 1200px) {
			  body .container .player {
			    width: 570px;
			  }
			}
			body .container .player .large-toggle-btn {
			  border: 1px solid #000;
			  border-radius:50%;
			  float: left; background:#fff;
			  font-size: 1.5em;
			  height: 50px;
			  margin: 0 10px 0 0;
			  overflow: hidden;
			  padding: 5px 0 0 0;
			  position: relative;
			  text-align: center;
			  vertical-align: bottom;
			  width: 54px; padding:4px 0 2px 4px;
			}
			body .container .player .large-toggle-btn .large-play-btn {
			  cursor: pointer;
			  display: inline-block;
			  position: relative;
			  top: -14%;
			}
			body .container .player .large-toggle-btn .large-play-btn:before {
			  content: "";
			  font: 1.5em/1.75 "FontAwesome";
			}
			body .container .player .large-toggle-btn .large-pause-btn {
			  cursor: pointer;
			  display: inline-block;
			  position: relative;
			  top: -13%;
			}
			body .container .player .large-toggle-btn .large-pause-btn:before {
			  content: "";
			  font: 1.5em/1.75 "FontAwesome";
			}
			body .container .player .info-box {
			  bottom: 10px;
			  left: 65px;
			  position: absolute;
			  top: 15px; width:70vw;
			}
			body .container .player .info-box .track-info-box {
			  float: left;
			  font-size: 12px;
			  margin: 0 0 6px 0;
			  visibility: hidden;
			  width: calc(100% - 40px);
			  *zoom: 1;
			}
			body .container .player .info-box .track-info-box .track-title-text {
			  display: inline-block;
			}
			body .container .player .info-box .track-info-box .audio-time {
			  display: inline-block;
			  padding: 0 0 0 5px;
			  width: 80px;
			}
			body .container .player .info-box .track-info-box:before, body .container .player .info-box .track-info-box:after {
			  content: " ";
			  display: table;
			}
			body .container .player .info-box .track-info-box:after {
			  clear: both;
			  display: block;
			  font-size: 0;
			  height: 0;
			  visibility: hidden;
			}
			body .container .player .progress-box {
			  float: left;
			  width:70vw;
			  position: relative;
			}
			body .container .player .progress-box .progress-cell {
			  height: 12px;
			  position: relative;
			}
			body .container .player .progress-box .progress-cell .progress {
			  background: #fff;
			  border: 1px solid #d9d9d9;
			  height: 8px;
			  position: relative;
			  width: auto;
			}
			body .container .player .progress-box .progress-cell .progress .progress-buffer {
			  background: #337ab7;
			  height: 100%;
			  width: 0;
			}
			body .container .player .progress-box .progress-cell .progress .progress-indicator {
			  background: #fff;
			  border: 1px solid #bebebe;
			  border-radius: 3px;
			  cursor: pointer;
			  height: 10px;
			  left: 0; 
			  overflow: hidden;
			  position: absolute;
			  top: -2px;
			  width: 22px;
			}
			body .container .player .controls-box {
			  bottom: 10px;
			  right:0;
			  position: absolute;
			}
			body .container .player .controls-box .previous-track-btn {
			  cursor: pointer;
			  display: inline-block;
			}
			body .container .player .controls-box .previous-track-btn:before {
			  content: "";
			  font: 1em "FontAwesome";
			}
			body .container .player .controls-box .next-track-btn {
			  cursor: pointer;
			  display: inline-block;
			}
			body .container .player .controls-box .next-track-btn:before {
			  content: "";
			  font: 1em "FontAwesome";
			}
			body .container .player:before, body .container .player:after {
			  content: " ";
			  display: table;
			}
			body .container .player:after {
			  clear: both;
			  display: block;
			  font-size: 0;
			  height: 0;
			  visibility: hidden;
			}
			body .container .play-list {
			  display: block;
			  margin: 24px auto 20px auto;
			  width: 100%;
			}
			body .container .play-list .play-list-row {
			  display: block;
			  margin: 10px 0;
			  width: 100%;
			  *zoom: 1;
			}
			body .container .play-list .play-list-row .track-title .playlist-track {
			  color:#<?= $txtColor ?>;
			  text-decoration: none;
			}
			body .container .play-list .play-list-row .track-title .playlist-track:hover {
			  text-decoration: underline;
			}
			body .container .play-list .play-list-row .small-toggle-btn {
			  border: 1px solid #000;
			  border-radius:50%;
			  cursor: pointer;
			  display: inline-block;
			  height: 20px;  background:#fff;
			  margin: 0 auto;
			  overflow: hidden;
			  position: relative;
			  text-align: center;
			  vertical-align: middle;
			  width: 20px; padding:2px 0 0 2px;
			}
			body .container .play-list .play-list-row .small-toggle-btn .small-play-btn {
			  display: inline-block;
			}
			body .container .play-list .play-list-row .small-toggle-btn .small-play-btn:before {
			  content: "";
			  font: 0.85em "FontAwesome";
			}
			body .container .play-list .play-list-row .small-toggle-btn .small-pause-btn {
			  display: inline-block;
			}
			body .container .play-list .play-list-row .small-toggle-btn .small-pause-btn:before {
			  content: "";
			  font: 0.85em "FontAwesome";
			}
			body .container .play-list .play-list-row .track-number {
			  display: inline-block; color:#fff;
			}
			body .container .play-list .play-list-row .track-title {
			  display: inline-block;
			}
			body .container .play-list .play-list-row .track-title .playlist-track {
			  text-decoration: none;
			}
			body .container .play-list .play-list-row .track-title .playlist-track:hover {
			  text-decoration: underline;
			}
			body .container .play-list .play-list-row .track-title.active-track {
			  font-weight: bold;
			}
			body .container .play-list .play-list-row:before, body .container .play-list .play-list-row:after {
			  content: " ";
			  display: table;
			}
			body .container .play-list .play-list-row:after {
			  clear: both;
			  display: block;
			  font-size: 0;
			  height: 0;
			  visibility: hidden;
			}
		</style>
	</body>
</html>