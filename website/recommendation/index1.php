<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Search and Recommendation</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/clean-blog.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
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
                <ul class="nav navbar-nav navbar-right">
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

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>Search  Recommendation</h1>
                        <hr class="small">
                        <span class="subheading">Start Your Search Here</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <form role="form"  id="SearchForm"  method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="search" placeholder="tilte or author" required>
                    </div>
                     <button type="submit" class="btn btn-primary btn-block btn-xs" name="indexSearch">Search</button>
                </form> 
                <hr>
                <div id='resultsArea'>
                    <?php if(isset($_POST["indexSearch"])):?>
                        <?php  
                            echo "<h3>Search Result:</h3><br>";
                            $keyword  = $_POST["search"]; 
                            //run query here
                            $rowcount = 7;
                            
                            $bookId = 1;
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
    
                            

                            for($i=0; $i<$rowcount; $i++){
                               //media object, image
                                       echo "<div class= 'media'><div class='row'><div class='col-xs-3 col-sm-3 col-md-2 pull-left '>
                                       <img class='media-object img-responsive mediaImg img-thumbnail' src=$imageURL alt='media object'>                                            </img></div>";

                                //media body
                                       //media heading
                                       echo "<div class='media-body'><div class='col-xs-9 col-sm-9 col-md-10'> <div class='row'>
                                       <a class='media-heading text-left' href='bookDetails.php?bookId=$bookId'><h3>$bookTitle</h3></a>
                                       </div>" ;

                                       echo "<div class='row'>";
                                      //author
                                       echo "<b>Author: </b>$authorName";
                                       echo "<br/>";

                                       //publisher
                                       echo "<b>Publisher: </b>$publisher";
                                       echo "<br/>";

                                       //language
                                       echo  "<b>Language: </b>$language";
                                       echo "<br/>";

                                       echo "</div></div></div>"; 
                                       echo "</div></div>"; 
                                
                                       echo "<hr>";
                                       
                                       $bookId +=1;
                            }

                        ?>
                   <?php endif; ?>
                </div>
            </div>
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
