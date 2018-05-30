<html>

<head>
    <title>JWT Encode/Decode</title>
    
    <style>
        
        #encoded{
            position: absolute;
            top: 50%;
            background-color: antiquewhite;
            padding-left: 10px;
            padding-right: 10px;

        }
        
        #decoded{
            position: absolute;
            top: 30%;
            left: 60%;
            background-color: bisque;
            padding-left: 10px;
            padding-right: 10px;
        }
        #jwtJSON3{
            background-color: #F0F0F0;
            color: #00b9f1;
        }
    
    </style>
</head>
    
    
<body>
    <center><h1>jwt Decode/Encode</h1></center>
    <div id="encoded">
        <center><h3>Encoded</h3></center>
        <form id="form1" >
            <textarea rows="20" cols="77" id="jwtString"></textarea><br>
            <input type="submit" value="Invia">
        </form>
    </div>
    <div id="decoded">
        <center><h3>Decoded</h3></center>
        <form id="form2">
            <p>HEADER:ALGORITHM &#38; TOKEN TYPE</p>
            <textarea rows="8" cols="77" id="jwtJSON1"></textarea><br>
            <p>PAYLOAD:DATA</p>
            <textarea rows="8" cols="77" id="jwtJSON2"></textarea><br>
            <p>VERIFY SIGNATURE</p>
            <textarea rows="8" cols="77" id="jwtJSON3"></textarea><br>
        </form>
    </div>
    
    
    <?php
        
        require_once 'php-jwt/src/JWT.php';
        require_once 'php-jwt/src/BeforeValidException.php';
        require_once 'php-jwt/src/SignatureInvalidException.php';
        require_once 'php-jwt/src/ExpiredException.php';
		use Firebase\JWT\JWT;
    

        $key = "example_key";
        $token = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000
        );

        /**
         * IMPORTANT:
         * You must specify supported algorithms for your application. See
         * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
         * for a list of spec-compliant algorithms.
         */
        $jwt = JWT::encode($token, $key);
        var_dump($jwt);
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        print_r($decoded);
        

        $decoded_array = (array) $decoded;
       
        var_dump($decoded_array);
        
    ?>
    
    
</body>

    
    
</html>