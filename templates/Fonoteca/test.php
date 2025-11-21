<ul>
<?php foreach($rolas as $item) : ?>
<img src="https://fonoteca.radiouas.org:8920/emby/Items/<?= $item->Id ?>/Images/Primary?format=jpg">

<audio controls>
  <source src="https://fonoteca.radiouas.org:8920/emby/Audio/<?= $item->Id ?>/stream.mp3?api_key=54416f1389784e36862041f024d8f679" type="audio/mpeg">
</audio>

<?php endforeach; ?>