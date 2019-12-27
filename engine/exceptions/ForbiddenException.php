<?php

namespace Exception;

class ForbiddenException extends \RuntimeException
{
    protected $message = 'Forbidden';
    protected $code = 403;
}