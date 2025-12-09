<?php
declare(strict_types=1);


namespace SPC\View;

use Cake\View\View;


class SPCView extends View
{

	private array $templates = [
		'nextActive' => '<a rel="next" href="{{url}}" class="w3-bar-item w3-button next">{{text}}</a>',
		'nextDisabled' => '<a class="w3-bar-item w3-button next disabled">{{text}}</a>',
		'prevActive' => '<a rel="prev" href="{{url}}" class="w3-bar-item w3-button prev">{{text}}</a>',
		'prevDisabled' => '<a class="w3-bar-item w3-button prev disabled">{{text}}</a>',

		'first' => '<a href="{{url}}" class="w3-bar-item w3-button first">{{text}}</a>',
		'last' => '<a href="{{url}}" class="w3-bar-item w3-button last">{{text}}</a>',
		'number' => '<a href="{{url}}" class="w3-bar-item w3-button">{{text}}</a>',
		'current' => '<a href="" class="w3-bar-item w3-button active">{{text}}</a>',
	];


	public function initialize(): void
	{
		$this->addHelper('Paginator', ['templates' => $this->templates]);
	}

}

