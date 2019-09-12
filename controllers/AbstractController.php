<?php

namespace P5blog\controllers;

use P5blog\models\Post;
use P5blog\models\User;

abstract class AbstractController
{
  protected $user;
  protected $post;
  protected $comment;
}
