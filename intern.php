#!/usr/bin/php -q

<?php

/**
 * Created by IntelliJ IDEA.
 * User: saveroo
 * Date: 25/10/16
 * Time: 18:29
 */
class HijupInternAbsentLogger
{
    public $data = array();
    private $bufferHandler;
    static $logFilename = 'intern_logger.txt';
    public $logger;
    public $lineCount;

    function __construct()
    {
        $this->getLines($this->getLogFilename());
//        $this->setData("Name", "Surga Savero");
//
//        $header = "#\n";
//        $data = "# Date".static::nowDate();
//        $data .= "\n# Name: ".$this->data['name'];
        $this->Buffer();
    }

    /**
     * @return array
     */
    public function getData($key)
    {
        return $this->data[$key];
    }

    /**
     * @param array $data
     */
    public function setData($key, $data)
    {
        $this->data[$key] = $data;
    }

    public static function nowDate()
    {
        return date("(M) || d-m-Y || H:i:s T");
    }

    /**
     * @param mixed $lineCount
     */
    public function setLineCount($lineCount)
    {
        $this->lineCount = $lineCount;
    }

    /**
     * @return mixed
     */
    public function getLineCount()
    {
        return $this->lineCount;
    }

    /**
     * @return mixed
     */
    public function getLogFilename()
    {
        return self::$logFilename;
    }

    /**
     * @param mixed $logFilename
     */
    public function setLogFilename($logFilename)
    {
        self::$logFilename = $logFilename;
    }

    /**
     * @return mixed
     */
    public function getBufferHandler()
    {
        return $this->bufferHandler;
    }

    /**
     * @param mixed $bufferHandler
     */
    public function setBufferHandler($bufferHandler)
    {
        $this->bufferHandler = $bufferHandler;
    }

    private function Buffer()
    {
        $this->setBufferHandler(fopen(HijupInternAbsentLogger::getLogFilename(), 'a+'));
    }

    public function In($dataInput)
    {
        $this->Buffer();
        if ($this->getBufferHandler()) {
            $split = str_split($dataInput);
            for ($i = 0; $i < count($split); $i++) {
                $this->getLines($this->getLogFilename());
                $lines = $this->getLineCount();

                if ($i == 0) {
                    fwrite($this->getBufferHandler(), $lines . '. ');
                    fwrite($this->getBufferHandler(), $split[$i]);
                } else {
                    fwrite($this->getBufferHandler(), $split[$i]);
                }
                echo $split[$i];
                usleep(20 * 1000);
                if ($split[$i] == count($split)) {
                    break;
                }
            }

            fclose(($this->getBufferHandler()));
            return true;
        } else {
            return false;
        }
    }


    public function Out($dataInput)
    {
//        $this->Buffer();
//        if ($this->getBufferHandler()) {
//            if ($localBuffer = fread($this->getBufferHandler(), filesize($this->getLogFilename())))
//                var_dump($localBuffer);
//        }
//        return false;
        $this->Buffer();
        if ($this->getBufferHandler()) {
            if (fwrite($this->getBufferHandler(), $dataInput)) {
                fclose(($this->getBufferHandler()));
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getLogger()
    {

        return file_get_contents($this->getLogFilename());
    }

    /**
     * @param mixed $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    public function getLines($file)
    {
        $linecount = 0;
        $handle = fopen($file, "r");
        while (!feof($handle)) {
            $line = fgets($handle);
            $linecount++;
        }

        fclose($handle);

        $this->setLineCount($linecount);
    }
}

$logger = new HijupInternAbsentLogger();
echo HijupInternAbsentLogger::nowDate();


$shell = fopen('php://stdin', 'r');
$userInput = '';
while ($userInput != "quit") {
    Info();
    echo "\n>";
    $userInput = trim(fgets($shell));
    while ($userInput == "1") {
        while ($userInput != "back") {
            echo "Name>";
            $userInput = trim(fgets($shell));
            if ($userInput != null) {
                $logger->setData('name', $userInput);
                $logger->setData('action', "Masuk");
                $logger->In("\n");
                $logger->In("\n");
                $logger->In("\n");
                $logger->In("Masuk\n");
                $logger->In("############################## \n");
                $logger->In("# Name: " . $logger->getData("name") . "\n");
                $logger->In("# Time: " . HijupInternAbsentLogger::nowDate() . "\n");
                $logger->In("# Jam: " . date("H:i:s") . "\n");
                $logger->In("# Supposed to get Out FROM THE OFFICE at: " . date("H:i:s T", strtotime("+9 hours")) . "\n");
                $logger->In("############################## \n");

//                fwrite(STDOUT, $logger->getData('name'));
//                echo ">";
//                $userInput = trim(fgets($shell));
                break;
            }
        }
    }

    if ($userInput == "2") {
        // if(@$logger->getData("action") != null){
        // if($logger->getData('action') === "Masuk") {
        echo "Name>";
        $userInput = trim(fgets($shell));
        if ($userInput != null) {
            $logger->setData('action', "Keluar");

            $logger->In("\n");
            $logger->In("\n");
            $logger->In("\n");
            $logger->In("Keluar\n");
            $logger->In("############################## \n");
            $logger->In("# Name: " . $logger->getData('name') . "\n");
            $logger->In("# Date: " . HijupInternAbsentLogger::nowDate() . "\n");
            $logger->In("# Jam: " . date("H:i:s") . "\n");
            $logger->In("# Rest Time: " . date("H:i:s T", strtotime("+15 hours")) . "\n");
            $logger->In("############################## \n");

            //                fwrite(STDOUT, $logger->getData('name'));
//                if($logger->getData('action') == "Keluar")
//                break;
            // }
            // }
        }
    }
    if ($userInput == "3") {
//        while($userInput != "back"){
        echo $logger->getLogger();
//            echo "\n>";
//            continue;
//            $userInput = trim(fgets($shell));
//        }
    }
}

function Info()
{
    $data = "\n# Menu Utama";
    $data .= "\n1. Log In\n";
    $data .= "2. Log Out\n";
    $data .= "3. Get Log\n";
    $data .= "Type to exit: quit\n";
    echo $data;
}
