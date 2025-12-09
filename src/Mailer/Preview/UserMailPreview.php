return $this->getMailer("User")
->welcome($user)
->setViewVars(["activationToken" => "dummy-token"]);
}
}
