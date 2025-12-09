<!DOCTYPE html>
<html>
	<head>
	    <meta charset="UTF-8">
	    <title>Carrusel de Videos</title>
	    <style>
		  .video-gallery-container {
			max-width: 1000px;
			margin: 0 auto;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		  }

		  /* Reproductor Principal (16:9) */
		  .main-stage {
			position: relative;
			padding-bottom: 56.25%; /* Ratio 16:9 */
			height: 0;
			background: #000;
			margin-bottom: 20px;
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 4px 15px rgba(0,0,0,0.2);
		  }

		  .main-stage iframe {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		  }

		  /* Contenedor de Miniaturas */
		  .thumbnails-track {
			display: grid;
			/* Grid responsivo: columnas de mínimo 180px */
			grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
			gap: 15px;
		  }

		  /* Tarjeta de Miniatura */
		  .video-thumb {
			cursor: pointer;
			position: relative;
			border-radius: 8px;
			overflow: hidden;
			transition: all 0.3s ease;
			aspect-ratio: 16/9;
			border: 2px solid transparent;
		  }

		  .video-thumb img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			display: block;
		  }

		  /* Estados de la miniatura */
		  .video-thumb:hover {
			transform: translateY(-5px);
			box-shadow: 0 5px 15px rgba(0,0,0,0.3);
		  }

		  .video-thumb.active {
			border-color: #ff0000;
			opacity: 0.6;
			pointer-events: none; /* Desactiva clic si ya está activo */
		  }

		  /* Overlay con icono Play */
		  .thumb-overlay {
			position: absolute;
			top: 0; left: 0; right: 0; bottom: 0;
			background: rgba(0,0,0,0.4);
			display: flex;
			align-items: center;
			justify-content: center;
			opacity: 0;
			transition: opacity 0.3s;
		  }

		  .video-thumb:hover .thumb-overlay {
			opacity: 1;
		  }

		  .play-icon {
			color: #fff;
			font-size: 30px;
			filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
		  }
		  
		  /* Título pequeño en miniatura (opcional) */
		  .thumb-title {
			position: absolute;
			bottom: 0;
			left: 0;
			width: 100%;
			background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
			color: white;
			font-size: 12px;
			padding: 20px 5px 5px 5px;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		  }
		.title {
			color: #333;
			font-size: 1.8em;
			margin-bottom: 10px;
			padding: 0 5px;
			font-weight: 600;
			border-bottom: 2px solid #ff0000;
			padding-bottom: 5px;
		}
		#video-desc {
			margin-bottom:32px;
			padding:16px;
			border-bottom: 2px solid #ff0000;
		}
	    </style>
	</head>
  <body>
	<div class="video-gallery-container">
		<?= $this->fetch('content');?>
	</div>
		

  </body>
</html>