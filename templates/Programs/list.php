	<ul class="qt-collapsible qt-chart-tracklist qt-$chartstyle" data-collapsible="accordion">
		
				<?php foreach($tracklist->Items as $item) {
						if(ctype_digit(substr($item->Name, 0, 8))) {
							$title = $this->Time->format(\DateTimeImmutable::createFromFormat('Ymd+', $item->Name), "d 'de' MMMM 'de' YYYY");
							
						} else {
							$title = $item->Name;
						}
				?>
				
					<li id="chartItem-<?= $item->Id ?>" class="qt-collapsible-item qt-part-chart qt-chart-track qt-card-s">
						<div class="qt-chart-table collapsible-header qt-content-primary">
							<div class="qt-position qt-content-primary-dark">
								
								<p class="qt-capfont qt-text-shadow">
									<img src="https://emby.radiouas.org:8920/emby/Items/<?= $item->Id ?>/Images/Primary?format=jpg&api_key=6581b7624a4c4868b7ca44d80a3e0641">
								</p>
							</div>
							<div class="qt-titles">
								<h4 class="qt-ellipsis qt-t"><?= $title ?></h4>
								<p><?= $item->Artists[0] ?></p>
							</div>
						</div>
						<div id="chartPlayer342" class="collapsible-body qt-paper">
							<audio controls>
								<source src="https://emby.radiouas.org:8920/emby/Audio/<?= $item->Id ?>/stream.mp3?api_key=6581b7624a4c4868b7ca44d80a3e0641" type="audio/mpeg">
							</audio>
						</div>
					</li>
					
					
				<?php	} ?>
				</ul>
				<div class="row tracklist-footer">
					<div class="col s12 m6 l6" style="text-align:left;">
						<?= $tracklist->TotalRecordCount ?> archivos encontrados
					</div>
					<div class="col s12 m6 l6" style="text-align:right;">
						<?php if($tracklist->TotalRecordCount > $maxTracks) { ?>
						<button onclick="next(2)">Siguiente</button>
						<?php } ?>
					</div>
	</div>

	<script>
					let startingPage = 1;
					function next(){
						$jQuery.ajax(function(){
							url:'https://spc.radiouas.org/api/programs/list',
							data: {'limit':30, 'page':2},
							success: function(response){
								document.getElementById("emby-tracklist").innerHTML = response;
							}
						});
					}
				</script>