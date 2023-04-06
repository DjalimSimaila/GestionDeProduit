<?php

final class View {

    public static function show (string $path, Array $params = array()){
        $S_file = Constants::viewsDir() . $path . '.php';
        $S_header = Constants::viewsDir() . 'header.php';
        $S_footer = Constants::viewsDir() . 'footer.php';
        $A_view = $params;

        ob_start();
        include $S_header;
        include_once $S_file;
        include $S_footer;
        ob_end_flush();
    }
}

?>
