<?php
if (\DIRECTORY_SEPARATOR !== '\\') {
    die("!!! DO NOT RUN TESTS ON PRODUCTION !!!\n");
}
passthru("php bin" . DIRECTORY_SEPARATOR . "test");