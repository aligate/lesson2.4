<?php
require_once 'functions.php';
header('Content-Type: image/png');
$code = generateCaptchaText(3);
saveCaptcha($code);
getCaptcha($code);
