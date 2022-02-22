<!DOCTYPE html>
<html>
<body>

<?php  
    
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    
    
    $_SESSION['url'] = $url;

    echo $_SESSION['url'];  
  ?>   

<a href="get_link2.php">click</a>
<?php
    // $previous = "javascript:history.go(-1)";
    // if(isset($_SERVER['HTTP_REFERER'])) {
    // $previous = $_SERVER['HTTP_REFERER'];
    // }
 
    // var_dump($previous);
?>

<?php
    // echo "<div id='demo'></div>";
?>

<script type="text/JavaScript">
  
// // Function is called, return 
// // value will end up in x
// var x = myFunction(11, 10);   
// document.getElementById("demo").innerHTML = x;
  
// // Function returns the product of a and b
// function myFunction(a, b) {
//     return a * b;             
// }

// var x = window.location.href;
// document.getElementById("demo").innerHTML = x;
</script>


<!-- 
<h2>Get the current URL</h2>

<p id="demo"></p>

<script>
document.getElementById("demo").innerHTML = 
"The full URL of this page is:<br>" + window.location.href;
</script>

</body>
</html> -->
