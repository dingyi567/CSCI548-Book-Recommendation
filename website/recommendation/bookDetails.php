<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Details</title>
</head>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/bookDetails.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>

 <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index1.php">Start Search</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index1.php">Home</a>
                    </li>
                    <li>
                        <a href="authorList.html">Author List</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>


    <!-- Main Content -->
    <div class="container" id="bookInfo">
        <div class="thumbnail">
        <?php 
        if(isset($_GET["bookURI"])){       
            $bookURI  = $_GET["bookURI"]; 
            //query database
            require_once "/Applications/MAMP/htdocs/recommendation/phpSesame/phpSesame.php";
            $sesame = array('url' => 'http://localhost:8080/openrdf-sesame', 'repository' => '1');     
            $store = new phpSesame($sesame['url'], $sesame['repository']);
            $resultFormat = phpSesame::SPARQL_XML; // The expected return type, will return a phpSesame_SparqlRes object (Optional)
            $lang = "sparql"; // Can also choose SeRQL (Optional)
            $infer = true; // Can also choose to explicitly disallow inference. (Optional)

            $sparql =  "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                        PREFIX dbp: <http://dbpedia.org/property/>
                        PREFIX db: <http://dbpedia.org/>
                        PREFIX dbr: <http://dbpedia.org/resource/>
                        PREFIX re: <http://www.w3.org/2000/10/swap/reason#>
                        prefix foaf: <http://xmlns.com/foaf/0.1/>
                        prefix : <http://dbpedia.org/ontology/>
                        prefix res: <http://dbpedia.org/resource/>
                        prefix schema: <http://schema.org/>
                        SELECT  distinct ?x ?authorURI ?amazonBookLink ?description ?imageURL ?bookTitle ?authorName ?numberOfPages ?language ?publisher ?isbn ?Goodreads_recommendImage ?Goodreads_recommendAuthor ?Goodreads_recommendTitle ?Goodreads_recommendURL
                        WHERE {
                        ?x a schema:Book.
                        filter(?x=<". $bookURI .">).
                        OPTIONAL{?x schema:image ?imageURL.}
                        ?x schema:name ?bookTitle.

                        ?x schema:amazonlinks ?amazonBookLink.
                        OPTIONAL{?x schema:amazonlinks/schema:numberOfPages ?numberOfPages.}
                        OPTIONAL{?x schema:amazonlinks/schema:inLanguage ?language.}
                        OPTIONAL{?x schema:amazonlinks/schema:publisherandedition ?publisher.}
                        OPTIONAL{?x schema:amazonlinks/schema:isbn ?isbn.}
                        OPTIONAL{?x schema:amazonlinks/schema:description ?description.}

                        ?x schema:author ?authorURI.
                        OPTIONAL{?x schema:author/schema:name ?authorName.}

                        OPTIONAL{?x schema:recommendImage ?Goodreads_recommendImage.}
                        OPTIONAL{?x schema:recommendAuthor ?Goodreads_recommendAuthor.}
                        OPTIONAL{?x schema:recommendTitle ?Goodreads_recommendTitle.}
                        OPTIONAL{?x schema:recommendURL ?Goodreads_recommendURL.}

                        }";   

            $result = $store->query($sparql, $resultFormat, $lang, $infer);

            if($result->hasRows()) {
                    foreach($result->getRows() as $row) {
                            //for book info part
                            $bookURI = $row['x'];
                            $imageURL = $row['imageURL'];
                            $bookTitle = $row['bookTitle'];
                            $amazonBookLink = $row['amazonBookLink'];
                            $numberOfPages = $row['numberOfPages'];
                            $language = $row['language'];
                            $publisher = $row['publisher'];
                            $isbn13 = $row['isbn'];
                            $description = $row['description'];
                            $authorURI = $row['authorURI'];
                            $authorName = $row['authorName'];

                            //for recommendation from goodreads part
                            $Goodreads_recommendImage = $row['Goodreads_recommendImage'];
                            $Goodreads_recommendAuthor = $row['Goodreads_recommendAuthor'];
                            $Goodreads_recommendTitle = $row['Goodreads_recommendTitle'];
                            $Goodreads_recommendURL = $row['Goodreads_recommendURL'];


                           echo "<div class='row'>";
                                //imageURL
                               echo "<div class='col-xs-3 col-sm-3 col-md-2'>
                                        <br/>
                                        <img class='bookImage img-thumbnail' src=$imageURL alt='media object'></img>
                                     </div>";
                               
                                //bookTitle amazonBookLink
                               echo "<div class='col-xs-9 col-sm-9 col-md-10'>";


                                    echo"<h3>$bookTitle &nbsp;<a class='small-link' href=$amazonBookLink> Amazon Link</a></h3>";
                                    //authorURI, authorName, 
                                    echo "<b>by </b><a href='authorDetails.php?authorURI=$authorURI'>$authorName</a>
                                    &nbsp;<a class='small-link' href=$authorURI>GoodReads Link</a></br>";

                                    //description!!!!!!
                                    echo "<div class='bookInfoDesc'><br/>";                  
                                        echo $description;
                                        echo "<hr>";
                                    echo "</div>";
                                    
                                    echo "<div class='bookInfoItems'>";

                                       //publisher
                                    if(!empty($publisher)){ 
                                       echo "<b>Publisher: </b>$publisher";
                                       echo "<br/>";
                                    }
                                       //language
                                    if(!empty($language)){
                                       echo  "<b>Language: </b>$language";
                                       echo "<br/>";
                                    }
                                        
                                       //paperback
                                    if(!empty($numberOfPages)){
                                       echo  "<b>Paperback: </b>$numberOfPages";
                                       echo "<br/>";
                                    }
                                        
                                       //ISBN13
                                    if(!empty($isbn13)){
                                       echo  "<b>ISBN-13: </b>$isbn13";
                                       echo "<br/><br/>";
                                    }
                                    
                                     echo "</div>";//bookinfoitems
                                
                               echo "</div>"; 

                           echo "</div>"; //row
                    }
            }
            else{
                echo "no results";
            }    

          }
            
 

        ?>
        </div>
    </div>
    <div class="container" id="authorInfo">
        <div class="thumbnail">
        <?php 
        //authorBooks dbpediaURI influencedBy influencing
        if(isset($_GET["bookURI"])){
            //$bookURI  = $_GET["bookURI"]; 
            $sparql =  "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                        PREFIX dbp: <http://dbpedia.org/property/>
                        PREFIX db: <http://dbpedia.org/>
                        PREFIX dbr: <http://dbpedia.org/resource/>
                        PREFIX re: <http://www.w3.org/2000/10/swap/reason#>
                        prefix foaf: <http://xmlns.com/foaf/0.1/>
                        prefix : <http://dbpedia.org/ontology/>
                        prefix res: <http://dbpedia.org/resource/>
                        prefix schema: <http://schema.org/>
                        SELECT  distinct ?x ?authorDbpediaURI ?authorGenre ?authorDescription ?authorNationalities ?authorBirthDate ?authorGender ?authorImage ?authorsBooks ?authorInfluenced ?authorInfluencedBy
                        WHERE {
                        ?x a schema:Person.
                        filter(?x=<". $authorURI .">).

                        ?x schema:dbpediaURI ?authorDbpediaURI.
                        OPTIONAL{?x schema:genre ?authorGenre.}
                        OPTIONAL{?x schema:description ?authorDescription.}
                        OPTIONAL{?x schema:nationalities ?authorNationalities.}
                        OPTIONAL{?x schema:birthDate ?authorBirthDate.}
                        OPTIONAL{?x schema:gender ?authorGender.}
                        OPTIONAL{?x schema:image ?authorImage.}
                        OPTIONAL{?x schema:authorsBooks ?authorsBooks.}
                        OPTIONAL{?x schema:influenced ?authorInfluenced.}
                        OPTIONAL{?x schema:influencedBy ?authorInfluencedBy.}

                        }";   

            $result = $store->query($sparql, $resultFormat, $lang, $infer);

            if($result->hasRows()) {
                $authorGenre = [];
                $authorDescription = [];
                $authorNationalities = [];
                $authorBirthDate = [];
                $authorGender = [];
                $authorImage = [];
                $authorInfluencedBy = [];
                $authorInfluenced = [];
                $authorsBooks = [];

                foreach($result->getRows() as $row) {
                        //for author info part

                        $authorGenre_Temp = explode(";;", $row['authorGenre']);
                        foreach($authorGenre_Temp as $genre_Temp){
                            if(!in_array($genre_Temp, $authorGenre)){
                                array_push($authorGenre, $genre_Temp);
                            }
                        }

                        if(!in_array($row['authorDescription'], $authorDescription)){
                            array_push($authorDescription, $row['authorDescription']);
                        }
                        if(!in_array($row['authorNationalities'], $authorNationalities)){
                            array_push($authorNationalities, $row['authorNationalities']);
                        }
                        if(!in_array($row['authorBirthDate'], $authorBirthDate)){
                            array_push($authorBirthDate, $row['authorBirthDate']);
                        }
                        if(!in_array($row['authorGender'], $authorGender)){
                            array_push($authorGender, $row['authorGender']);
                        }
                        if(!in_array($row['authorsBooks'], $authorsBooks)){
                            array_push($authorsBooks, $row['authorsBooks']);
                        }
                        if(!in_array($row['authorInfluencedBy'], $authorInfluencedBy)){
                            array_push($authorInfluencedBy, $row['authorInfluencedBy']);
                        }
                        if(!in_array($row['authorInfluenced'], $authorInfluenced)){
                            array_push($authorInfluenced, $row['authorInfluenced']);
                        }
                        
                        $authorImage = $row['authorImage'];
                        $authorDbpediaURI = $row['authorDbpediaURI'];
                        
                }

                echo "<h3>$authorName</h3><br/>";
                echo "<div class='authorInfoItems'>";

                //author info row 
                echo "<div class='row'>";
                   //imageURL
                   echo "<div class='col-xs-3 col-sm-3 col-md-2'>
                            <img class='authorImage img-thumbnail' src=$authorImage alt='media object'></img>
                        </div>";
                   
                    //info
                    echo "<div class='col-xs-9 col-sm-9 col-md-10'>";

                    $authorGenre = array_filter($authorGenre);
                    $authorDescription = array_filter($authorDescription);
                    $authorBirthDate = array_filter($authorBirthDate);
                    $authorGender = array_filter($authorGender);
                    $authorNationalities = array_filter($authorNationalities);
                    $authorsBooks = array_filter($authorsBooks);
                    $authorInfluencedBy = array_filter($authorInfluencedBy);
                    $authorInfluenced = array_filter($authorInfluenced);

                    if(!empty($authorGenre)){
                        echo "<b>Genre: </b>".implode("/",$authorGenre). "<br/>";
                    }
                    if(!empty($authorDescription)){ 
                        echo "<b>Description: </b>".implode(" ",$authorDescription). "<br/>";
                    }
                    if(!empty($authorBirthDate)){ 
                        echo "<b>Birthdate: </b>".implode(" ",$authorBirthDate). "<br/>";
                    }
                    if(!empty($authorGender)){ 
                        echo "<b>Gender: </b>".implode(" ",$authorGender). "<br/>";
                    }
                    if(!empty($authorNationalities)){
                        echo "<b>Nationality: </b>".implode(" ",$authorNationalities). "<br/>";
                    }

                    echo "</div>";
                echo "</div>";//row

        //author works
                if(!empty($authorsBooks)){

                    // echo "<hr/>";
                    // echo "<div class='container' id='otherBooks'>";
                    // echo "<h4>Other Books</h4><br/>";
                    
                    $sparql =  "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                    PREFIX dbp: <http://dbpedia.org/property/>
                    PREFIX db: <http://dbpedia.org/>
                    PREFIX dbr: <http://dbpedia.org/resource/>
                    PREFIX re: <http://www.w3.org/2000/10/swap/reason#>
                    prefix foaf: <http://xmlns.com/foaf/0.1/>
                    prefix : <http://dbpedia.org/ontology/>
                    prefix res: <http://dbpedia.org/resource/>
                    prefix schema: <http://schema.org/>
                    SELECT  distinct ?x ?bookTitle ?imageURL
                    WHERE {";   
                    for($i=0; $i<count($authorsBooks); $i++){
                        $allBooks = explode(";", $authorsBooks[$i]);
                        //echo count($allBooks);
                        $allBooks = array_filter($allBooks);
                        $j = 0;
                        foreach ($allBooks as $theBook) {
                            //echo "theBook-". $j ."  ".$theBook. "</br>";
                             $string = "{ 
                                ?x a schema:Book.
                                filter(?x=<$theBook>).

                                ?x schema:name ?bookTitle.
                                OPTIONAL{?x schema:image ?imageURL.}
                                
                                }";
                            $sparql .= $string;
                            if($j!=count($allBooks)-1){
                                $sparql .= "UNION";
                            }
                            $j = $j + 1;
                        }
                        //echo count($allBooks);
                        //echo "<b>allBooks: $i</b>".implode(" ",$allBooks). "<br/>";
                        //echo "------<br/>";

                    }
                    $sparql .= "}";
                    //print_r("<br/>sparql--".$sparql);
                    $authorsBooks_Result = $store->query($sparql, $resultFormat, $lang, $infer);

                    //echo "</div>";//container

                    if($authorsBooks_Result->hasRows()) {
                        echo "<hr/>";
                        echo "<div class='container' id='otherBooks'>";
                            echo "<h4>Other Books</h4><br/>";
                            echo "<div class='row'>";
                                foreach($authorsBooks_Result->getRows() as $authorsBooks_Book) {
                                    $authorsBooks_Book_bookTitle = $authorsBooks_Book['bookTitle'];
                                    $authorsBooks_Book_imageURL= $authorsBooks_Book['imageURL'];
                                    $authorsBooks_Book_bookURI= $authorsBooks_Book['x'];
                                    echo "<div class='col-xs-3 col-sm-3 col-md-2'>
                                            <img class='bookImage img-thumbnail' src=$authorsBooks_Book_imageURL alt='media object'></img>
                                            <a class='small-link' href=bookDetails.php?bookURI=$authorsBooks_Book_bookURI><h6>$authorsBooks_Book_bookTitle</h6></a>
                                         </div>";
                                }
                            echo "</div>";//row
                        echo "</div>";//container
                    }
    
                    //test~!!!!!
                        // echo "<div class='container' id='otherBooks'>";
                        // echo "<h4>Other Books</h4><br/>";
                        // echo "<div class='row'>";
                    
                        //     $authorsBooks_Book_bookTitle = "Polar Quest";
                        //     $authorsBooks_Book_imageURL= "http://d.gr-assets.com/books/1347520057l/4788920.jpg";
                        //     $authorsBooks_Book_bookURI= "http://www.goodreads.com/book/show/4788920-polar-quest";
                            
                        //     echo "<div class='col-xs-3 col-sm-3 col-md-2'>
                        //             <img class='bookImage img-thumbnail' src=$authorsBooks_Book_imageURL alt='media object'></img>
                        //             <a class='small-link' href=bookDetails.php?bookURI=$authorsBooks_Book_bookURI><h6>$authorsBooks_Book_bookTitle</h6></a>
                                
                        //          </div>";

                        //     //echo $authorsBooks_Book['bookTitle']. "--" . $authorsBooks_Book['imageURL']. "<br/>";
               
                        // echo "</div>";//row
                        // echo "</div>";//container

                }

                //authorInfluencedBy info
                if(!empty($authorInfluencedBy)){
                    echo "<hr/>";
                    echo "<div class='container' id='influenceByInfo'>";
                    echo "<h4>Influenced By: </h4><br/>";

                    $sparql =  "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                    PREFIX dbp: <http://dbpedia.org/property/>
                    PREFIX db: <http://dbpedia.org/>
                    PREFIX dbr: <http://dbpedia.org/resource/>
                    PREFIX re: <http://www.w3.org/2000/10/swap/reason#>
                    prefix foaf: <http://xmlns.com/foaf/0.1/>
                    prefix : <http://dbpedia.org/ontology/>
                    prefix res: <http://dbpedia.org/resource/>
                    prefix schema: <http://schema.org/>
                    SELECT  distinct ?x ?authorName ?authorImage ?authorDbpediaURI
                    WHERE {";   

          
                    $j = 0;
                    foreach ($authorInfluencedBy as $theAuthor) {
                        //echo "theAuthor-". $j ."  ".$theAuthor. "</br>";
                         $string = "{ 
                            ?x a schema:Person.
                            ?x schema:name ?authorName.
                            ?x schema:image ?authorImage.
                            ?x schema:dbpediaURI ?authorDbpediaURI.
                            filter(?authorDbpediaURI=\"$theAuthor\").
                        }";
                        $sparql .= $string;
                        if($j!=count($authorInfluencedBy)-1){
                            $sparql .= "UNION";
                        }
                        $j = $j + 1;
                    }                    
                    $sparql .= "}";
                    //print_r("<br/>sparql--".$sparql);

                    $authorInfluencedBy_Result = $store->query($sparql, $resultFormat, $lang, $infer);

                    if($authorInfluencedBy_Result->hasRows()) {
                            echo "<div class='row'>";
                                foreach($authorInfluencedBy_Result->getRows() as $authorInfluencedBy_Author) {
                                    $authorInfluencedBy_Author_authorName= $authorInfluencedBy_Author['authorName'];
                                    $authorInfluencedBy_Author_authorImage= $authorInfluencedBy_Author['authorImage'];
                                    $authorInfluencedBy_Author_authorURI= $authorInfluencedBy_Author['x'];
                                    echo "<div class='col-xs-3 col-sm-3 col-md-2' >
                                            <div class='authorImage_Container' style='width: 150px;height: 200px;'>
                                                <img class='authorImage img-thumbnail' src=$authorInfluencedBy_Author_authorImage alt='media object' style='width:100%;'></img>
                                            </div>
                                            <a class='small-link' href=authorDetails.php?authorURI=$authorInfluencedBy_Author_authorURI><h5>$authorInfluencedBy_Author_authorName</h5></a>
                                         </div>";
                                }
                            echo "</div>";//row
                    }
                    echo "</div>";//container
                }
                

                //authorInfluenced info
                 if(!empty($authorInfluenced)){
                    echo "<hr/>";
                    echo "<div class='container' id='influencedInfo'>";
                    echo "<h4>Influencing: </h4><br/>";

                    $sparql =  "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                    PREFIX dbp: <http://dbpedia.org/property/>
                    PREFIX db: <http://dbpedia.org/>
                    PREFIX dbr: <http://dbpedia.org/resource/>
                    PREFIX re: <http://www.w3.org/2000/10/swap/reason#>
                    prefix foaf: <http://xmlns.com/foaf/0.1/>
                    prefix : <http://dbpedia.org/ontology/>
                    prefix res: <http://dbpedia.org/resource/>
                    prefix schema: <http://schema.org/>
                    SELECT  distinct ?x ?authorName ?authorImage ?authorDbpediaURI
                    WHERE {";   

          
                    $j = 0;
                    foreach ($authorInfluenced as $theAuthor) {
                        //echo "theAuthor-". $j ."  ".$theAuthor. "</br>";
                         $string = "{ 
                            ?x a schema:Person.
                            ?x schema:name ?authorName.
                            ?x schema:image ?authorImage.
                            ?x schema:dbpediaURI ?authorDbpediaURI.
                            filter(?authorDbpediaURI=\"$theAuthor\").
                        }";
                        $sparql .= $string;
                        if($j!=count($authorInfluenced)-1){
                            $sparql .= "UNION";
                        }
                        $j = $j + 1;
                    }                    
                    $sparql .= "}";
                    //print_r("<br/>sparql--".$sparql);

                    $authorInfluenced_Result = $store->query($sparql, $resultFormat, $lang, $infer);

                    if($authorInfluenced_Result->hasRows()) {
                            echo "<div class='row'>";
                                foreach($authorInfluenced_Result->getRows() as $authorInfluenced_Author) {
                                    $authorInfluenced_Author_authorName= $authorInfluenced_Author['authorName'];
                                    $authorInfluenced_Author_authorImage= $authorInfluenced_Author['authorImage'];
                                    $authorInfluenced_Author_authorURI= $authorInfluenced_Author['x'];
                                    echo "<div class='col-xs-3 col-sm-3 col-md-2' >
                                            <div class='authorImage_Container' style='width: 150px;height: 200px;'>
                                                <img class='authorImage img-thumbnail' src=$authorInfluenced_Author_authorImage alt='media object' style='width:100%;'></img>
                                            </div>
                                            <br/><a class='small-link' href=authorDetails.php?authorURI=$authorInfluenced_Author_authorURI><h5>$authorInfluenced_Author_authorName</h5></a>
                                         </div>";
                                }
                            echo "</div>";//row
                    }
                    echo "</div>";//container
                }

            }

        }

        ?>
        </div>
    </div>


    <div class="container" id="recommend_From_Amazon">
        <div class="thumbnail">
            <?php 
        //
        if(isset($_GET["bookURI"])){
           
            $sparql =  "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                        PREFIX dbp: <http://dbpedia.org/property/>
                        PREFIX db: <http://dbpedia.org/>
                        PREFIX dbr: <http://dbpedia.org/resource/>
                        PREFIX re: <http://www.w3.org/2000/10/swap/reason#>
                        prefix foaf: <http://xmlns.com/foaf/0.1/>
                        prefix : <http://dbpedia.org/ontology/>
                        prefix res: <http://dbpedia.org/resource/>
                        prefix schema: <http://schema.org/>
                        SELECT  distinct ?x ?amazonBookLink ?recommendImage ?recommendAuthor ?recommendTitle ?recommendURL
                        WHERE {
                        ?x a schema:Book.
                        ?x schema:amazonlinks ?amazonBookLink.
                        filter(?amazonBookLink=<$amazonBookLink>).
                        OPTIONAL{?x schema:amazonlinks/schema:recommendImage ?recommendImage.}
                        OPTIONAL{?x schema:amazonlinks/schema:recommendAuthor ?recommendAuthor.}
                        OPTIONAL{?x schema:amazonlinks/schema:recommendTitle ?recommendTitle.}
                        OPTIONAL{?x schema:amazonlinks/schema:recommendURL ?recommendURL.}
                        }";   

            $recommend_From_GoodReads_Result = $store->query($sparql, $resultFormat, $lang, $infer);

            if($recommend_From_GoodReads_Result->hasRows()) {
                foreach($recommend_From_GoodReads_Result->getRows() as $row) {
                        $recommendImage = $row['recommendImage'];
                        $recommendAuthor = $row['recommendAuthor'];
                        $recommendTitle = $row['recommendTitle'];
                        $recommendURL = $row['recommendURL'];
                }
                $recommendImage = explode(";;", $recommendImage);
                $recommendAuthor = explode(";;", $recommendAuthor);
                $recommendTitle = explode(";;", $recommendTitle);
                $recommendURL = explode(";;", $recommendURL);

                $recommendImage = array_filter($recommendImage);
                $recommendAuthor = array_filter($recommendAuthor);
                $recommendTitle = array_filter($recommendTitle);
                $recommendURL = array_filter($recommendURL);

                // $j=1;
                // echo "image:<br/>";
                // foreach ($recommendImage as $key) {
                //     echo $j. ":  ". $key. "<br/>";
                //     $j +=1;
                // }
                // $j=1;

                // echo "Author$j:<br/>";
                // foreach ($recommendAuthor as $key) {
                //     echo $j. ":  ". $key. "<br/>";
                //     $j +=1;
                // }
                // $j=1;

                // echo "Title$j:<br/>";
                // foreach ($recommendTitle as $key) {
                //     echo $j. ":  ". $key. "<br/>";
                //     $j +=1;
                // }
                // $j=1;

                // echo "URL$j:<br/>";
                // foreach ($recommendURL as $key) {
                //     echo $j. ":  ". $key. "<br/>";
                //     $j +=1;
                // }


                $recommendSize = count($recommendTitle);
                //echo $recommendSize."<br/>";

                echo "<h3>Recommendations From Amazon:</h3><br/>";
                echo "<div class='Recommend_From_Amazon_Container'>";
                echo "<div class='row'>";
                for($i=0; $i<$recommendSize; $i++){
                    

                    $the_author_name = $recommendAuthor[$i];
                    $the_image_URL = $recommendImage[$i];
                    $the_book_title = $recommendTitle[$i];
                    $the_book_link = $recommendURL[$i];

                    // echo $i. "name:  ". $the_author_name. "<br/>";
                    // echo $i. "image:  ". $the_image_URL . "<br/>";
                    // echo $i. "title:  ". $the_book_title . "<br/>";
                     //echo $i. "link:  ". $the_book_link. "<br/>";

                    echo "<div class='bookItem col-md-2' >
                                <div class='bookImage_Container' style='width: 150px;height: 200px;'>
                                    <a class='small-link' href=http://$the_book_link><img class='bookImage img-thumbnail' src=$the_image_URL alt='media object' style='height:100%;'></img></a>
                                </div></br>

                                <div class='a-row'><h5>$the_book_title</h5></div>

                                <div class='a-row'><h5>by $the_author_name</h5></div>

                          </div>";
                }   
                echo "</div>";//row
                echo "</div>";//recommend from amazon container
            }
        }
                
              
        ?>


        </div>
    </div>

    <div class="container" id="recommend_From_GoodReads">
        <div class="thumbnail">
            <?php 
        //
        if(isset($_GET["bookURI"])){
            if(!empty($Goodreads_recommendTitle)){
                $Goodreads_recommendImage = explode(";;", $Goodreads_recommendImage);
                $Goodreads_recommendAuthor = explode(";;", $Goodreads_recommendAuthor);
                $Goodreads_recommendTitle = explode(";;", $Goodreads_recommendTitle);
                $Goodreads_recommendURL = explode(";;", $Goodreads_recommendURL);

                $Goodreads_recommendImage = array_filter($Goodreads_recommendImage);
                $Goodreads_recommendAuthor = array_filter($Goodreads_recommendAuthor);
                $Goodreads_recommendTitle = array_filter($Goodreads_recommendTitle);
                $Goodreads_recommendURL = array_filter($Goodreads_recommendURL);

                // $j=1;
                // echo "image:<br/>";
                // foreach ($Goodreads_recommendImage as $key) {
                //     echo $j. ":  ". $key. "<br/>";
                //     $j +=1;
                // }
                // $j=1;

                // echo "Author$j:<br/>";
                // foreach ($Goodreads_recommendAuthor as $key) {
                //     echo $j. ":  ". $key. "<br/>";
                //     $j +=1;
                // }
                // $j=1;

                // echo "Title$j:<br/>";
                // foreach ($Goodreads_recommendTitle as $key) {
                //     echo $j. ":  ". $key. "<br/>";
                //     $j +=1;
                // }
                // $j=1;

                // echo "URL$j:<br/>";
                // foreach ($Goodreads_recommendURL as $key) {
                //     echo $j. ":  ". $key. "<br/>";
                //     $j +=1;
                // }

                $recommendSize = count($Goodreads_recommendTitle);
                 //echo $recommendSize."<br/>";

                echo "<h3>Recommendations From GoodReads:</h3><br/>";
                echo "<div class='Recommend_From_GoodReads_Container'>";
                echo "<div class='row'>";
                for($i=0; $i<$recommendSize; $i++){
                    $the_author_name = $Goodreads_recommendAuthor[$i];
                    $the_image_URL = $Goodreads_recommendImage[$i];
                    $the_book_title = $Goodreads_recommendTitle[$i];
                    $the_book_link = $Goodreads_recommendURL[$i];

                    echo "<div class='bookItem col-md-2' >
                                <div class='bookImage_Container' style='width: 150px;height: 200px;'>
                                    <a class='small-link' href=http://$the_book_link><img class='bookImage img-thumbnail' src=$the_image_URL alt='media object' style='height:100%;'></img></a>
                                </div></br>

                                <div class='a-row'><h5>$the_book_title</h5></div>

                                <div class='a-row'><h5>by $the_author_name</h5></div>

                          </div>";
                }   
                echo "</div>";//row
                echo "</div>";//recommend from amazon container
            

            }
        }
 
        ?>
            
        </div>
    </div>



    
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <!-- customed  JavaScript -->
    <script src="js/clean-blog.min.js"></script>


</body>

</html>