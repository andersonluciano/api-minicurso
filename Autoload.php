<?php

$dir = scandir('Controllers');


foreach ($dir as $class){
    if(trim($class) != "." && trim($class) != ".."){
        
        include __DIR__."/Controllers/".$class;
    }
}