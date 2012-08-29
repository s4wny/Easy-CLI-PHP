<?php

require '../cmd.php';



$nick = prompt("Enter your nick:");                      //Ask something, dont care about input at all
$age  = prompt("Enter your age:", "> 0", "???");         //Ask something, if the input IS NOT bigger then 0, the value will be set to ???.
$num  = prompt("Enter a number bigger then 4:", "> 3");  //Ask something untill the condition is fulfilled.


e("Hello '$nick'!");
e();
e("You are $age years old.");
e();
e("Your number are: $num");


?>