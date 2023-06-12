<?php

use Core\Authenticator;

(new Authenticator)->logout();

redirect('/');