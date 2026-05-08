<?php
declare(strict_types=1);

namespace SPC\Controller;

use Cake\Http\Response;

class PagesController extends AppController
{
  public function display(string ...$path): Response
  {
    $result = $this->Authentication->getResult();
    if ($result->isValid()) {
      return $this->redirect('/admin/dashboard');
    }
  }
}