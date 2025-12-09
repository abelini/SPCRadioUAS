<p><?= $legend ?></p>

<ul>
<?php if(!empty($comments)) : ?>

	<?php foreach($comments as $comment) : ?>
	<?php
		
		$time = new \DateTimeImmutable($comment->created_time);
		$tz = new \DateTimeZone('America/Hermosillo');
		//debug($comment->created_time); //debug($this->Time->format(\DateTimeInterface::W3C));
		//debug($this->Time->format($time, 'Y-m-d'));
	?>
	<li>
		<p>
			<span class="time"><?=  $this->Time->format($time, "hh:mm:ss aaa", false, $tz); ?></span>
			<span class="name"><?= $comment->from->name ?? 'Usuario de Facebook' ?>:</span>
			<span><?= $comment->message ?></span>
				<?php if(isset($comment->parent)) : ?>
				<blockquote>
					<p><?= $comment->parent->message ?></p>
				</blockquote>
				<?php endif; ?>
		</p>
	</li>
	
	<?php endforeach; ?>

<?php else : ?>
	<li></li>
<?php endif; ?>
</ul>

<style>
p{font-size:42px;padding:24px 0 0 36px}
blockquote {background:#fff;border:1px #ccc solid; margin:32px; padding:16px; font-size:smaller;}
</style>