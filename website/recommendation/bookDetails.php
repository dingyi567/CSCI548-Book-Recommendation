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
        if(isset($_GET["bookId"])){
            $keyword  = $_GET["bookId"]; 
            //echo $keyword;

            //using bookId to do query, return book info, author info, and influence network

            $bookId = 1;
            $authorId = 1;
            $imageURL = "http://ecx.images-amazon.com/images/I/51ag2-oxh6L._SY344_BO1,204,203,200_QL70_.jpg";
            $bookTitle = "Hunters in the Dark (HALO)";
            $bookURL = "http://www.amazon.com/Hunters-Dark-HALO-Peter-David/dp/1476795851";
            $authorName = "Peter David";
            $authorLink = "www.amazon.com/Peter-David/e/B000APYOHU";
            $paperBack = "368 pages";
            $language = "English";
            $publisher = "Gallery Books (June 16, 2015)";
            $ISBN_10 =" 1476795851";
            $ISBN_13 =" 978-1476795850";
            $description = "<br><div> It is 2555, more than two years after the Master Chief went missing-in-action following a decisive conflict on Installation 00\u2014the massive, extragalactic Forerunner construct known as the Ark\u2014as part of the final chapter in humanity\u2019s bloody thirty-year struggle against the overwhelming forces of the Covenant. Now, as a tenuous peace exists between the humans and the Elites, a startling scientific discovery is made\u2026and the riddle behind its Forerunner origins could very well seal the fate of the entire galaxy within a matter of weeks. In order to unravel these dangerous secrets, a heroic, hastily formed coalition of humans and Elites must attempt to overcome their differences as they embark on a covert mission back to the Ark\u2014an astonishing, enigmatic place beyond comprehension from which few have returned and where mortal danger awaits them all\u2026</div>";

           //image
           echo "<div class='row'><div class='col-xs-3 col-sm-3 col-md-2'>
           <img class='bookImage img-thumbnail' src=$imageURL alt='media object'>
           </img></div>";
           
            //book title
           echo "<div class='col-xs-9 col-sm-9 col-md-10'>
           <div class='row'>
           <h3>$bookTitle &nbsp;<a class='small-link' href=$bookURL> Amazon Link</a></h3>
           </div>" ;

            //author
           echo "<div class='row'>
           <b>by </b><a href='authorDetails.php?authorId=$authorId'>$authorName</a>
           &nbsp;<a class='small-link' href=$authorLink>Amazon Link</a>
           </div>";
           echo "<br/>";

            echo "<div class='bookInfoDesc'>";
            //description
            echo $description;
            echo "<hr>";
            echo "</div>";
            
           echo "<div class='bookInfoItems'>";
           //publisher
           echo "<b>Publisher: </b>$publisher";
           echo "<br/>";

           //language
           echo  "<b>Language: </b>$language";
           echo "<br/>";
            
           //paperback
           echo  "<b>Paperback: </b>$paperBack";
           echo "<br/>";
            
           //ISBN10
           echo  "<b>ISBN-10: </b>$ISBN_10";
           echo "<br/>";
            
           //ISBN13
           echo  "<b>ISBN-13: </b>$ISBN_13";
           echo "<br/><br/>";
            
           echo "</div>";//bookinfoitems
            
           echo "</div>"; 
           echo "</div>"; //row

        }
        ?>
        </div>
    </div>
    <div class="container" id="authorInfo">
        <div class="thumbnail">
        <?php 
        if(isset($_GET["bookId"])){
            $bookId  = $_GET["bookId"]; 

            //run query here, using bookId to get authorId, authorInfo

            //remember to test if it is a null, influence iterator
            $authorId = "1";
            $authorName = "Barry Hannah";
            $authorURI = "http://dbpedia.org/resource/Barry_Hannah";
            $authorBirthdate = "1942-04-23";
            $authorDesc = "Short story writer, novelist, professor";
            $authorGenre = "Fantasy, adventure novel, mainstream fiction";
            $authorNationality = "America";
            $authorVid = "123";
            $authorInfluencedBy = "";
            $authorInfluenced = "";

            echo "<h3>$authorName</h3><br/>";
            echo "<div class='authorInfoItems'>";
                echo "<b>Genre: </b>$authorGenre<br/>";
                echo "<b>Description: </b>$authorDesc<br/>";
                echo "<b>Birthdate: </b>$authorBirthdate<br/>";
                echo "<b>Nationality: </b>$authorNationality<br/>";
                echo "<b>Influencing: </b><br/>";
                echo "<b>Influenced By: </b>";
            
            echo "</div>";
            

        }
        ?>
        </div>
    </div>
    
    <div class="container" id="influenceInfo">
    </div>
    
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <!-- customed  JavaScript -->
    <script src="js/clean-blog.min.js"></script>


</body>

</html>