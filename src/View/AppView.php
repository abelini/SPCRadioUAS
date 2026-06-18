<?php
declare(strict_types=1);


namespace SPC\View;

use Cake\View\View;


class AppView extends View
{

	private array $templates = [
		'nextActive' => '<a rel="next" href="{{url}}" class="paginator-btn next">{{text}}</a>',
		'nextDisabled' => '<a class="paginator-btn next disabled">{{text}}</a>',
		'prevActive' => '<a rel="prev" href="{{url}}" class="paginator-btn prev">{{text}}</a>',
		'prevDisabled' => '<a class="paginator-btn prev disabled">{{text}}</a>',

		'first' => '<a href="{{url}}" class="paginator-btn first">{{text}}</a>',
		'last' => '<a href="{{url}}" class="paginator-btn last">{{text}}</a>',
		'number' => '<a href="{{url}}" class="paginator-btn">{{text}}</a>',
		'current' => '<a href="" class="paginator-btn active">{{text}}</a>',
	];


	public function initialize(): void
	{
		$this->addHelper('Paginator', ['templates' => $this->templates]);
	}

}

