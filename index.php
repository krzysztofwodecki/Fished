<?php

    class A {
        function __toString(){
            return 'wiad';
        }
    }

   $className = 'A';
   $instance = new $className();

    echo $instance

?>