<?php
require_once 'components/functions.php';
session_destroy();
header('Location: index.php');