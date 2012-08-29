<?php

require '../cmd.php';



$nick = prompt("Enter your nick:");
$age  = prompt("Enter your age:", "> 0", "???");
$num  = prompt("Enter a number bigger then 4:", "> 3");


e("Hello '$nick'!");
e();
e("You are $age years old.");
e();
e("Your number are: $num");


?>