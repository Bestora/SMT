<?php

$stat = new Infrastruktur();
template::setText('sys', $stat->getStatistik());

?>
        